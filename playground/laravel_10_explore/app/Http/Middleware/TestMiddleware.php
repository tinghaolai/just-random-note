<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $test): Response
    {
        Log::info('Test context: ' . $test);
        Log::info('test13 - before api handle');
        $response = $next($request);
        Log::info('test13 - after api handle');

        return $response;
    }

    public function terminate(Request $request, Response $response): void
    {
        Log::info('test 13: api terminate');
    }
}
