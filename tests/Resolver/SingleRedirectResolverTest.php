<?php

namespace Jidoka1902\RedirectingFallbacks\Tests\Resolver;


use Jidoka1902\RedirectingFallbacks\Resolver\RedirectResolver;
use Jidoka1902\RedirectingFallbacks\Resolver\SingleRedirectResolver;
use Jidoka1902\RedirectingFallbacks\UrlGenerator\UrlGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SingleRedirectResolverTest extends TestCase
{

    const OUTPUT = "/";

    /** @var RedirectResolver */
    private $resolver;

    /** @var MockObject */
    private $urlGenerator;

    protected function setUp()
    {
        $this->urlGenerator = $this->getMockForAbstractClass(UrlGenerator::class);

        $this->resolver = new SingleRedirectResolver($this->urlGenerator, self::OUTPUT);
    }

    /**
     * the SingleRedirectResolver should be able to resolve always
     * @param $requestPath
     * @dataProvider getCanResolveTestData
     */
    public function testCanResolve($requestPath)
    {
        /** @var boolean $actualResult */
        $actualResult = $this->resolver->canResolve($requestPath);

        $this->assertTrue($actualResult);

    }

    /**
     * @return array
     */
    public function getCanResolveTestData(): array
    {
        return [
            "root" => ["/"],
            "posts" => ["/posts"],
            "not even a uri path" => ["000"]
        ];
    }

    /**
     * assert that the configured redirect path will always be returned
     * the internal behaviour of the UrlGenerator is abstracted by a mock because
     * it is irrelevant
     * @param $requestPath
     * @param $expectedResult
     * @dataProvider getResolveOutputTestData
     */
    public function testResolveOutput($requestPath, $expectedResult)
    {
        $this->urlGenerator->method("generate")->willReturnArgument(0);

        /** @var string|null $actualResult */
        $actualResult = $this->resolver->resolve($requestPath);

        $this->assertEquals($expectedResult, $actualResult);

    }

    /**
     * @return array
     */
    public function getResolveOutputTestData(): array
    {
        return [
            "root" => ["/", self::OUTPUT],
            "posts" => ["/posts", self::OUTPUT],
            "not even a uri path" => ["000", self::OUTPUT]
        ];
    }

    /**
     * assert that the UrlGenerator::generate() is called
     * @param $requestPath
     * @dataProvider getUrlGeneratorIsCalledTestData
     */
    public function testUrlGeneratorIsCalled($requestPath)
    {
        $this->urlGenerator->expects($this->exactly(1))->method("generate");

        $this->resolver->resolve($requestPath);

    }

    /**
     * @return array
     */
    public function getUrlGeneratorIsCalledTestData(): array
    {
        return [
            "root" => ["/"],
            "posts" => ["/posts"],
            "not even a uri path" => ["000"]
        ];
    }
}