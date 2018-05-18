<?php

namespace Jidoka1902\RedirectingFallbacks\Cache;


class ArrayCache implements RedirectResolverCache
{

    /** @var array */
    private $container;

    /**
     * ArrayCache constructor.
     */
    public function __construct()
    {
        $this->container = array();
    }

    /**
     * @param string $requestPath
     * @return bool
     */
    public function isHit(string $requestPath): bool
    {
        if (array_key_exists($requestPath, $this->container)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $requestPath
     * @param string $resolvedPath
     */
    public function set(string $requestPath, string $resolvedPath)
    {
        $this->container[$requestPath] = $resolvedPath;
    }

    /**
     * @param string $requestPath
     * @return null|string
     */
    public function get(string $requestPath)
    {
        if (!$this->isHit($requestPath)) {
            return null;
        }

        return $this->container[$requestPath];
    }

}