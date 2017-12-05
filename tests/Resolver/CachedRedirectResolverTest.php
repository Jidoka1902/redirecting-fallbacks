<?php

namespace Jidoka1902\RedirectingFallbacks\Tests\Resolver;

use Jidoka1902\RedirectingFallbacks\Cache\RedirectResolverCache;
use Jidoka1902\RedirectingFallbacks\Resolver\CachedRedirectResolver;
use Jidoka1902\RedirectingFallbacks\Resolver\RedirectResolver;
use PHPUnit\Framework\TestCase;

/**
 * Class CachedRedirectResolverTest
 * @package Jidoka1902\RedirectingFallbacks\Tests\Resolver
 */
class CachedRedirectResolverTest extends TestCase
{
    public function testResolveCallIsCached()
    {
        $originResolver = $this->getMockForAbstractClass(RedirectResolver::class);
        $originResolver->expects($this->exactly(1))->method("resolve");

        $cache = $this->getMockForAbstractClass(RedirectResolverCache::class);
        $cache->method("isHit")->willReturn(true);

        $cachedResolver = new CachedRedirectResolver($originResolver, $cache);

        # this combination on an MultipleRedirectResolver would normally
        # cause two calls to resolve, one within canResolve, one the original call
        $cachedResolver->canResolve("/");
        $cachedResolver->resolve("/");

        # even if the resolve adapter is called a second time, the cache impl must hit
        $cachedResolver->resolve("/");

    }

    public function testInitialResolveResultPassthrough()
    {
        $originResolver = $this->getMockForAbstractClass(RedirectResolver::class);
        $originResolver->method("resolve")->willReturn("/");

        $cache = $this->getMockForAbstractClass(RedirectResolverCache::class);
        $cache->method("isHit")->willReturn(false);

        $cachedResolver = new CachedRedirectResolver($originResolver, $cache);

        /** @var string|null $actualResult */
        $actualResult = $cachedResolver->resolve("/");

        $this->assertEquals("/", $actualResult);
    }
}