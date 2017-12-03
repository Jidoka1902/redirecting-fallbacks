<?php

namespace App\Service\Redirect\Resolver;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SingleRedirectResolver implements RedirectResolver
{

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var string */
    private $target;

    public function __construct(UrlGeneratorInterface $urlGenerator, string $target)
    {
        $this->urlGenerator = $urlGenerator;
        $this->target = $target;
    }

    public function canResolve(string $requestPath): bool
    {
        return true;
    }

    public function resolve(string $requestPath): ?string
    {
        return $this->urlGenerator->generate($this->target);
    }

}