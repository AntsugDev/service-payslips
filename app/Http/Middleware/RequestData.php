<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $requestUri = $request->getRequestUri();
        $headers    = $request->headers;

        if($request->has('data')){
            $response = $request->merge($request->all()['data']);
            $response->request->remove('data');
            return $next($response);
        }
        if($request->expectsJson()) {
            if (stristr($requestUri, 'api/oauth') === false && $request->has('**api**')) {
                if (!$headers->has('authorization') ||
                    ($headers->has('authorization') && stristr($headers->get('authorization'), 'Bearer') == false)
                ) {
                    $response = new Response();
                    return $response->setStatusCode(401);
                }
            }
        }
        return $next($request);
    }
}
