<?php

namespace App\Service\Redirect\Resolver;

interface RedirectResolver
{
    /**
     * @param string $requestPath
     * @return bool
     */
    public function canResolve(string $requestPath): bool;

    /**
     * @param string $requestPath
     * @return string|null
     */
    public function resolve(string $requestPath): ?string;
}