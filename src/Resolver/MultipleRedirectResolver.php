<?php

namespace Jidoka1902\RedirectingFallbacks\Resolver;


use Jidoka1902\RedirectingFallbacks\Config\RedirectResolverConfig;
use Jidoka1902\RedirectingFallbacks\UrlGenerator\UrlGenerator;

class MultipleRedirectResolver implements RedirectResolver
{

    /** @var array */
    private $redirectMapping;

    /** @var UrlGenerator */
    private $urlGenerator;

    public function __construct(array $mapping, UrlGenerator $urlGenerator)
    {
        $this->redirectMapping = $mapping;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $requestPath
     * @return bool
     */
    public function canResolve(string $requestPath): bool
    {

        /** @var string|null $resolvedMapping */
        $resolvedMapping = $this->resolve($requestPath);

        if ($resolvedMapping === null) {
            return false;
        }

        return true;
    }

    /**
     * @param string $requestPath
     * @return string|null
     */
    public function resolve(string $requestPath): ?string
    {

        foreach ($this->redirectMapping as $item) {

            if (strpos($requestPath, $item[RedirectResolverConfig::PATH_KEY]) === 0) {

                /** @var string $redirectPath */
                $redirectPath = $this->urlGenerator->generate($item[RedirectResolverConfig::TARGET_KEY]);

                # prevent redirecting to the same path and so creating a loop
                if ($requestPath === $redirectPath) {
                    continue;
                }

                return $redirectPath;
            }

        }

        return null;
    }

}