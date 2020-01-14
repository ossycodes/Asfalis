<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
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
            return $this->addCorrectContentType(new Response('', 406));
        }
        if ($request->isMethod('POST') || $request->isMethod('PATCH')) {
            if ($request->headers->get("content-type") !== "application/vnd.api+json") {
                return $this->addCorrectContentType(new Response('', 415));
            }
        }

        //add correct header (content-type = application/vnd.api+json) to response (adhering to JSON:API spec)
        return $this->addCorrectContentType($next($request));
    }

    private function addCorrectContentType(BaseResponse $response)
    {
        $response->headers->set('content-type', 'application/vnd.api+json');
        return $response;
    }
}
