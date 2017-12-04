<?php

namespace Jidoka1902\RedirectingFallbacks\Cache;


interface RedirectResolverCache
{
    public function isHit(string $requestPath): bool;

    public function set(string $requestPath, string $resolvedPath): void;

    public function get(string $requestPath): ?string;
}