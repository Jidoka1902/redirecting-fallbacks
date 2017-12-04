<?php

namespace Jidoka1902\RedirectingFallbacks\UrlGenerator;


class PassthroughUrlGenerator implements UrlGenerator
{

    /**
     * just pass-through the configured redirect-path
     * @param string $path
     * @return string
     */
    public function generate(string $path): string
    {
        return $path;
    }

}