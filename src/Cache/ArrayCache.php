<?php

namespace Jidoka1902\RedirectingFallbacks\Cache;


class ArrayCache implements RedirectResolverCache
{

    /** @var array */
    private $container;

    public function __construct()
    {
        $this->container = array();
    }

    public function isHit(string $requestPath): bool
    {
        if (array_key_exists($requestPath, $this->container)) {
            return true;
        }

        return false;
    }

    public function set(string $requestPath, string $resolvedPath): void
    {
        $this->container[$requestPath] = $resolvedPath;
    }

    public function get(string $requestPath): ?string
    {
        if (!$this->isHit($requestPath)) {
            return null;
        }

        return $this->container[$requestPath];
    }

}