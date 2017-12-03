<?php

namespace App\Service\Redirect\UrlGenerator;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FrameworkUrlGeneratorAdapter implements UrlGenerator
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * takes the name of a configured symfony router route
     * @param string $route
     * @return string
     */
    public function generate(string $route): string
    {
        return $this->router->generate($route);
    }


}