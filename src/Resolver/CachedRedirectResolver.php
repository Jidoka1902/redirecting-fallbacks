<?php

namespace Jidoka1902\RedirectingFallbacks\Resolver;


use Jidoka1902\RedirectingFallbacks\Cache\ArrayCache;
use Jidoka1902\RedirectingFallbacks\Cache\RedirectResolverCache;

class CachedRedirectResolver implements RedirectResolver
{

    /** @var RedirectResolver */
    private $resolver;

    /** @var RedirectResolverCache */
    private $cache;

    public function __construct(RedirectResolver $resolver, RedirectResolverCache $cache = null)
    {
        $this->resolver = $resolver;
        $this->cache = ($cache instanceof RedirectResolverCache) ? $cache : new ArrayCache();
    }

    public function canResolve(string $requestPath): bool
    {
        /** @var string|null $resolvedPath */
        $resolvedPath = $this->resolver->resolve($requestPath);

        if ($resolvedPath === null) {
            return false;
        }

        return true;
    }

    public function resolve(string $requestPath): ?string
    {

        if ($this->cache->isHit($requestPath)) {
            return $this->cache->get($requestPath);
        }

        /** @var string|null $resolvedPath */
        $resolvedPath = $this->resolver->resolve($requestPath);

        $this->cache->set($requestPath, $resolvedPath);

        return $resolvedPath;

    }

}