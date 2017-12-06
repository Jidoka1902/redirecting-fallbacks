# redirecting-fallbacks
## Goals
The "redirecting-fallbacks" project aims to give developers a standard framework to configure redirects. 
But this needs some Integration work into your Framework of choice.

Therefore this is just a very lean backend for further integrations.

## Audience
This library is for developers.

If you have any proposals for enhancements or just found a bug, please let me know via [github-issues][2] or even create a [pull-request][3] ;) 

## Symfony
For the Symfony ecosystem, there is already an [integration][1] provided. If you need some inspiration how this library
could work within a framework, please have a look there.

## Parts explained
### RedirectResolver
RedirectResolvers are the brain of this tiny project. They need a configuration to find out if they can give you a 
redirect target for an url path.

- The __SingleRedirectResolver__ implementation just needs one redirect path configured and every requested route will return that
target.
- The __MultipleRedirectResolver__ takes a list of "paths" and "targets". So you can specify a hierarchy of redirects. E.g. 
the request to /posts will give you another target than the request to "/".
- If you have long lists of Redirect Configurations or another __RedirectResolver__ which takes quiet a bit time to resolve
the request-path - there is a __CachedRedirectResolver__ implementation. This just caches your RedirectResolver::resolve() for
the case you need to call it twice of more often within your integration.

But wait - this lib just resolves configurations? Yes - what event you want to listen to is your integration stuff.

### RedirectResolverCache
The __RedirectResolverCache__ is just the extracted Caching behaviour from the __CachedRedirectResolver__. 
The default behaviour is an __ArrayCache__ so time consuming resolves will be reduced. But feel free to create your own
implementations to whatever seems important to you ;)

### UrlGenerator
The __UrlGenerator__ provides exchangeable behaviour for what your configured "targets" will be as result of the __RedirectResolver__::resolve() method.
So you could replace the __PassthroughUrlGenerator__ (wich just returns the resolved targets one-to-one). So within the 
Symfony Integration that could just be changed to an Symfony Router Adapter.

[1]: https://packagist.org/packages/jidoka1902/redirecting-fallbacks-symfony
[2]: https://github.com/jidoka1902/redirecting-fallbacks/issues/new
[3]: https://github.com/jidoka1902/redirecting-fallbacks/pulls