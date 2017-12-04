<?php

namespace Jidoka1902\RedirectingFallbacks\Cache;


class NullCache implements RedirectResolverCache
{
    public function isHit(string $requestPath): bool
    {
        return false;
    }

    public function set(string $requestPath, string $resolvedPath): void
    {
        //nothing to do
    }

    public function get(string $requestPath): ?string
    {
        return null;
    }

}