<?php

namespace Jidoka1902\RedirectingFallbacks\Resolver;


use Jidoka1902\RedirectingFallbacks\UrlGenerator\UrlGenerator;

class SingleRedirectResolver implements RedirectResolver
{

    /** @var UrlGenerator */
    private $urlGenerator;

    /** @var string */
    private $target;

    public function __construct(UrlGenerator $urlGenerator, string $target)
    {
        $this->urlGenerator = $urlGenerator;
        $this->target = $target;
    }

    public function canResolve(string $requestPath): bool
    {
        return true;
    }

    /**
     * @param string $requestPath
     * @return null|string
     */
    public function resolve(string $requestPath)
    {
        return $this->urlGenerator->generate($this->target);
    }

}