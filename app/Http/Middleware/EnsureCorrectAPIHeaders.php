<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class EnsureCorrectAPIHeaders
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
        if ($request->headers->get('accept') !== "application/vnd.api+json") {
            return new Response('', 406);
        }
        return $next($request);
    }
}
