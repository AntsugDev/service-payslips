<?php

namespace App\Exceptions;

use App\Http\Api\Core\Exceptions\BaseException;
use App\Http\Api\Core\Exceptions\BaseValidationException;
use App\Http\Api\Core\Exceptions\Client\BaseAuthenticationException;
use App\Http\Api\Core\Exceptions\Client\ForbiddenException;
use App\Http\Api\Core\Exceptions\Client\MethodNotAllowedException;
use App\Http\Api\Core\Exceptions\Client\ResourceNotFoundException;
use App\Http\Api\Core\Exceptions\Server\InternalServerErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    /**
     * @param $request
     * @param Throwable $e
     * @return Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        $accept_json = $request->expectsJson();
        if ($accept_json) {
            if ($e instanceof ModelNotFoundException) // Route - Model Binding fails
                return (new ResourceNotFoundException)->render($request);
            else if ($e instanceof AuthorizationException) // Permission denied to perform the action
                return (new ForbiddenException)->render($request);
            else if ($e instanceof MethodNotAllowedHttpException)
                return (new MethodNotAllowedException)->render($request);
            else if ($e instanceof ValidationException) {
                return (new BaseValidationException($e->validator, $e->response, $e->errorBag))->render($request);
            }
            else if ($e instanceof AuthenticationException )
                return (new BaseAuthenticationException)->render($request);
            else if($e instanceof \ErrorException)
                return new JsonResponse(array("errors"=> 'ErrorException:'.$e->getFile().':'.$e->getLine().' '.$e->getMessage()),Response::HTTP_UNPROCESSABLE_ENTITY);
            else if($e instanceof  UnauthorizedHttpException) {
                return new JsonResponse(array("errors" => 'Token expired e/o User not found('.$e->getMessage().')'), Response::HTTP_NOT_ACCEPTABLE);
            }
            else if($e instanceof  NotFound){
                return new JsonResponse(array("errors" => $e->getMessage()), Response::HTTP_NOT_ACCEPTABLE);
            }
            else if($e instanceof \Exception)
                return new JsonResponse(array("errors" => $e->getMessage()), Response::HTTP_NOT_ACCEPTABLE);
            else if (!$e instanceof BaseException)
                return (new InternalServerErrorException($e))->render($request);

        }
        return parent::render($request, $e);
    }
}
