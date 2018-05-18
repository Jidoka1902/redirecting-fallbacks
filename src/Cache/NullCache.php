<?php

namespace Jidoka1902\RedirectingFallbacks\Cache;


class NullCache implements RedirectResolverCache
{

    /**
     * @param string $requestPath
     * @return bool
     */
    public function isHit(string $requestPath): bool
    {
        return false;
    }

    /**
     * @param string $requestPath
     * @param string $resolvedPath
     * @return void
     */
    public function set(string $requestPath, string $resolvedPath)
    {
        //nothing to do
    }

    /**
     * @param string $requestPath
     * @return null|string
     */
    public function get(string $requestPath)
    {
        return null;
    }

}