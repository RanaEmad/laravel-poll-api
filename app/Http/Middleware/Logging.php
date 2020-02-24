<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;

use Closure;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::debug($request->method()." - On:".date("Y-m-d H:i:s"));
        return $next($request);
    }
}
