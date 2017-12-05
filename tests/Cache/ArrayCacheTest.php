<?php

namespace Jidoka1902\RedirectingFallbacks\Tests\Cache;


use Jidoka1902\RedirectingFallbacks\Cache\ArrayCache;
use Jidoka1902\RedirectingFallbacks\Cache\RedirectResolverCache;
use PHPUnit\Framework\TestCase;

class ArrayCacheTest extends TestCase
{

    /** @var RedirectResolverCache */
    private $cache;

    protected function setUp()
    {
        $this->cache = new ArrayCache();
    }

    /**
     * make sure the array cash hits correctly
     * @param $requestPath
     * @param $testValue
     * @param $expectedResult
     * @dataProvider getIsHitTestData
     */
    public function testIsHit($requestPath, $testValue, $expectedResult)
    {
        $this->cache->set($requestPath, "");

        $actualResult = $this->cache->isHit($testValue);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function getIsHitTestData(): array
    {
        return [
            "positive test case 1" => ["/test", "/test", true],
            "negative test case 2" => ["/test", "/no-test", false],
        ];
    }

    /**
     * make sure a set value will never be returned from the getter
     * @param $requestPath
     * @param $resolvedPath
     * @param $testValue
     * @param $expectedResult
     * @dataProvider getSetTestData
     */
    public function testSet($requestPath, $resolvedPath, $testValue, $expectedResult)
    {
        $this->cache->set($requestPath, $resolvedPath);

        $actualResult = $this->cache->get($testValue);

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    public function getSetTestData(): array
    {
        return [
            "test case 1" => ["/request", "/injected", "/request", "/injected"],
            "test case 2" => ["/request", "/not-injected", "/no-request", null],
        ];
    }
}