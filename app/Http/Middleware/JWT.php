<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWT
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
        //check if token provided by the user is valid or not. If it's not
        //valid, then throw an exception,which would be handled in our handler.php file.
        //else continue to the next request.

        //this is because the auth:api middleware that comes with JWT does not give us a 
        //detailed reason when it fails to validate the token.

        JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
