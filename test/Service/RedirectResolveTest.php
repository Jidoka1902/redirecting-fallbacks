<?php

namespace Tests\Service;


use App\Service\RedirectResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RedirectResolveTest extends TestCase
{

    /**
     * @param $configuration
     * @param $requestPath
     * @param $expectedResult
     * @dataProvider getResolveData
     */
    public function testResolve($configuration, $requestPath, $expectedResult)
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $generatorMock */
        $generatorMock = $this->getMockBuilder(UrlGeneratorInterface::class)->getMockForAbstractClass();

        $generatorMock->method('generate')->willReturnArgument(0);

        $resolver = new RedirectResolver($generatorMock, $configuration);

        $actualResult = $resolver->resolve($requestPath);

        $this->assertSame($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function getResolveData(): array
    {
        return array(
            "Assert Matching works with one configuration item" => array(
                "config" => array(
                    array("path" => "/", "target" => "app_index"),
                ),
                "request" => "/asdf",
                "result" => array("path" => "/", "target" => "app_index"),
            ),
            "Assert Matching works with more configuration items 1" => array(
                "config" => array(
                    array("path" => "/admin", "target" => "app_admin"),
                    array("path" => "/", "target" => "app_index"),
                ),
                "request" => "/asdf",
                "result" => array("path" => "/", "target" => "app_index"),
            ),
            "Assert Matching works with more configuration items 2" => array(
                "config" => array(
                    array("path" => "/admin", "target" => "app_admin"),
                    array("path" => "/", "target" => "app_index"),
                ),
                "request" => "/admin/asdf",
                "result" => array("path" => "/admin", "target" => "app_admin"),
            ),
            "Assert order counts with more configuration items 2" => array(
                "config" => array(
                    array("path" => "/", "target" => "app_index"),
                    array("path" => "/admin", "target" => "app_admin"),
                ),
                "request" => "/admin/asdf",
                "result" => array("path" => "/", "target" => "app_index"),
            ),
            "Assert path cannot be resolved" => array(
                "config" => array(
                    array("path" => "/admin", "target" => "app_admin"),
                ),
                "request" => "/asdf",
                "result" => array(),
            ),
        );
    }

    public function testIsResponsible()
    {
        $this->assertTrue(false);
    }

    public function testGetRedirectPath()
    {
        $this->assertTrue(false);
    }
}