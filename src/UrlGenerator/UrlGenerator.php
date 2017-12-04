<?php

namespace Jidoka1902\RedirectingFallbacks\UrlGenerator;


interface UrlGenerator
{

    public function generate(string $route): string;

}