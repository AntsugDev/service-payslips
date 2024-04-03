<?php

namespace App\Http\Middleware;

use App\Models\LoggerModel;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

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

            LoggerModel::create([
                "uuid" => Str::uuid()->toString(),
                "method" => $request->getMethod(),
                "name"=>$requestUri,
                "date_insert" => Carbon::now()->format('d/m/Y H:i:s'),
                "type" => "Request",
                "msg" => null,
            ]);

                if (stristr($requestUri, 'api/oauth') === false && $request->has('**api**')) {
                    if (!$headers->has('uuid') ||
                        ($headers->has('uuid') && stristr($headers->get('uuid'), 'Bearer') == false)
                    ) {
                        $response = new Response();
                        return $response->setStatusCode(401);
                    }
                }
        }
        $response =  $next($request);
        LoggerModel::create([
            "uuid" => Str::uuid()->toString(),
            "method" => $request->getMethod(),
            "name"=>$requestUri,
            "date_insert" => Carbon::now()->format('d/m/Y H:i:s'),
            "type" => "Response",
            "msg" => $response->getStatusCode(),
        ]);
        return $response;
    }
}
