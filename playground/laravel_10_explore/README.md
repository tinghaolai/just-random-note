## Why

* You can use it only if you know this feature exists, or you might waste time on building your own wheel.
* Learn how other programmer design their code through these features.
* Learn design pattern, structure, architecture, spirit, can be applied to other languages, learning other languages can also do the same thing.

## Source Code Questions

* How `env()` get from `.env` file?
* What's difference between `env()` and `$_ENV`?
* How Configuration Caching implemented?
* How Maintenance Mode implemented?
* Service container vs service provider
  * https://mark-lin.com/posts/20181214/
* Cors
  * how `config/cors.php` works
  * use `php artisan optimize` if somehow it doesn't work
    * Actually, not this problem, see below
  * Check why it doesn't work for web api, `/test8`, even set `'paths' => ['*','api/*', 'sanctum/csrf-cookie'],` in `cors.php` and `*` in `VerifyCsrfToken`
* Middleware
  * How middleware works?
    * code before and after `$response = $next($request);`
* Injection
  * How Constructor Injection works?
  * How Method Injection works?
  * How Request Injection works compared to vanilla PHP?
* How source code: middleware `cache.headers` works?
* How source code: error handler works?
