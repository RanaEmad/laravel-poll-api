<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;

use Closure;

class HandleNotFound
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
        $response = $next($request);
        if($response->status()==404){
            return response()->json(["message"=>"Resource Not Found"],404);
        }
        return $response;
    }
}
