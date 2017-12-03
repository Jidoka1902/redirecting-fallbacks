<?php

namespace App\Service\Redirect\UrlGenerator;


use Symfony\Component\Routing\Router;

class RouterUrlGenerator implements UrlGenerator
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
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