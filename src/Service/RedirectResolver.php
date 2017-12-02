<?php

namespace App\Service;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RedirectResolver
{

    private const TARGET_KEY = "target";

    private const PATH_KEY = "path";

    /** @var array */
    private $redirectMapping;

    /** @var array */
    private $resolvedRequestPaths;

    public function __construct(UrlGeneratorInterface $urlGenerator, array $mapping)
    {

        foreach ($mapping as &$item) {
            $item[self::TARGET_KEY] = $urlGenerator->generate($item[self::TARGET_KEY]);
        }

        $this->redirectMapping = $mapping;
        $this->resolvedRequestPaths = array();
    }

    /**
     * @param string $requestPath
     * @return bool
     */
    public function isResponsible(string $requestPath): bool
    {

        /** @var array $resolvedMapping */
        $resolvedMapping = $this->resolve($requestPath);

        if ($resolvedMapping === array()) {
            return false;
        }

        $this->resolvedRequestPaths[$requestPath] = $resolvedMapping[self::TARGET_KEY];

        return true;
    }

    /**
     * @param string $requestPath
     * @return array
     */
    public function resolve(string $requestPath): array
    {
        foreach ($this->redirectMapping as $item) {

            if (strpos($requestPath, $item[self::PATH_KEY]) === 0) {
                return $item;
            }

        }

        return array();
    }

    /**
     * @param string $requestPath
     * @return string|null
     */
    public function getRedirectPath(string $requestPath): ?string
    {
        if (array_key_exists($requestPath, $this->resolvedRequestPaths)) {
            return $this->resolvedRequestPaths[$requestPath];
        }

        /** @var array $resolvedMapping */
        $resolvedMapping = $this->resolve($requestPath);

        if ($resolvedMapping !== array()) {
            return $resolvedMapping[self::TARGET_KEY];
        }

        return null;
    }
}