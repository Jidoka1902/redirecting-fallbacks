<?php

namespace Jidoka1902\RedirectingFallbacks\Tests\Resolver;


use Jidoka1902\RedirectingFallbacks\Resolver\MultipleRedirectResolver;
use Jidoka1902\RedirectingFallbacks\Resolver\RedirectResolver;
use Jidoka1902\RedirectingFallbacks\UrlGenerator\UrlGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MultipleRedirectResolverTest extends TestCase
{

    /** @var MockObject */
    private $urlGenerator;

    protected function setUp()
    {
        $this->urlGenerator = $this->getMockForAbstractClass(UrlGenerator::class);

        $this->urlGenerator->method("generate")->willReturnArgument(0);

    }

    /**
     * the SingleRedirectResolver should be able to resolve always
     * @param $requestPath
     * @dataProvider getCanResolveTestData
     */
    public function testCanResolve($mapping, $requestPath, $expectedResult)
    {

        $resolver = new MultipleRedirectResolver($mapping, $this->urlGenerator);

        /** @var boolean $actualResult */
        $actualResult = $resolver->canResolve($requestPath);

        $this->assertEquals($expectedResult, $actualResult);

    }

    /**
     * @return array
     */
    public function getCanResolveTestData(): array
    {
        return [
            "redirect loop 1" => [
                [
                    ["path" =>"/posts", "target" => "/"],
                    ["path" =>"/", "target" => "/"]
                ],
                "/",
                false
            ],
            "redirect resolved 1" => [
                [
                    ["path" =>"/posts", "target" => "/"],
                    ["path" =>"/", "target" => "/"]
                ],
                "/asdf",
                true
            ],
            "redirect resolved 2" => [
                [
                    ["path" =>"/posts", "target" => "/"],
                ],
                "/posts/asdf",
                true
            ],
            "redirect not resolved 1" => [
                [
                    ["path" =>"/posts", "target" => "/"],
                ],
                "/asdf",
                false
            ],
        ];
    }

    /**
     * assert that the configured redirect path will always be returned
     * the internal behaviour of the UrlGenerator is abstracted by a mock because
     * it is irrelevant
     * @param $mapping
     * @param $requestPath
     * @param $expectedResult
     * @dataProvider getResolveOutputTestData
     */
    public function testResolveOutput($mapping, $requestPath, $expectedResult)
    {
        $this->urlGenerator->method("generate")->willReturnArgument(0);

        $resolver = new MultipleRedirectResolver($mapping, $this->urlGenerator);


        /** @var string|null $actualResult */
        $actualResult = $resolver->resolve($requestPath);

        $this->assertEquals($expectedResult, $actualResult);

    }

    /**
     * @return array
     */
    public function getResolveOutputTestData(): array
    {
        return [
            "redirect not resolved 1" => [
                [
                    ["path" =>"/posts", "target" => "/"],
                ],
                "/asdf",
                null
            ],
            "redirect resolved 1" => [
                [
                    ["path" =>"/posts/", "target" => "/posts"],
                    ["path" =>"/", "target" => "/"]
                ],
                "/asdf",
                "/"
            ],
            "redirect resolved 2" => [
                [
                    ["path" =>"/posts/", "target" => "/posts"],
                    ["path" =>"/", "target" => "/"]
                ],
                "/posts/asdf",
                "/posts"
            ],
            "redirect resolved 3 (order)" => [
                [
                    ["path" =>"/", "target" => "/"],
                    ["path" =>"/posts/", "target" => "/posts"],
                ],
                "/posts/asdf",
                "/"
            ],
        ];
    }
    
}