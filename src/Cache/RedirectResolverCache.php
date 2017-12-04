<?php

namespace App\Service\Redirect\Cache;


interface RedirectResolverCache
{
    public function isHit(string $requestPath): bool;

    public function set(string $requestPath, string $resolvedPath): void;

    public function get(string $requestPath): ?string;
}