<?php

namespace App\Service\Redirect\UrlGenerator;


interface UrlGenerator
{

    public function generate(string $route): string;

}