<?php

namespace Jidoka1902\RedirectingFallbacks\Tests\UrlGenerator;


use Jidoka1902\RedirectingFallbacks\UrlGenerator\PassthroughUrlGenerator;
use PHPUnit\Framework\TestCase;

class PassthroughUrlGeneratorTest extends TestCase
{
    public function testGeneratePassthrough()
    {
        $generator = new PassthroughUrlGenerator();

        $this->assertEquals("/", $generator->generate("/"));
    }
}