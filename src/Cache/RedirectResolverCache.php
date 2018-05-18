<?php

namespace Jidoka1902\RedirectingFallbacks\Cache;


interface RedirectResolverCache
{

    /**
     * @param string $requestPath
     * @return bool
     */
    public function isHit(string $requestPath): bool;

    /**
     * @param string $requestPath
     * @param string $resolvedPath
     */
    public function set(string $requestPath, string $resolvedPath);

    /**
     * @param string $requestPath
     * @return null|string
     */
    public function get(string $requestPath);

}