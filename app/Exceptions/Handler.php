<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    protected function prepareJsonResponse($request, Exception $e)
    {
        return response()->json([
            'errors' => [
                [
                    'title' => Str::title(Str::snake(class_basename(
                        $e
                    ), ' ')),
                    'details' => $e->getMessage(),
                ]
            ]
        ], $this->isHttpException($e) ? $e->getStatusCode() : 500);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        $errors = (new Collection($exception->validator->errors()))
            ->map(function ($error, $key) {
                return [
                    'title' => 'Validation Error',
                    'details' => $error[0],
                    'source' => [
                        'pointer' => '/' . str_replace('.', '/', $key),
                    ]
                ];
            })
            ->values();
        return response()->json([
            'errors' => $errors,
        ], $exception->status);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'errors' => [
                    [
                        'title' => 'Unauthenticated',
                        'details' => 'You are not authenticated',
                    ]
                ]
            ], 403);
        }
        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenBlacklistedException) {
            return response()->json([
                'errors' => [
                    [
                        'title' => Str::title(Str::snake(class_basename(
                            $exception
                        ), ' ')),
                        'details' => 'Token is expired',
                    ]
                ]
            ], $this->isHttpException($exception) ? $exception->getStatusCode() : Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof TokenExpiredException) {
            return response()->json([
                'errors' => [
                    [
                        'title' => Str::title(Str::snake(class_basename(
                            $exception
                        ), ' ')),
                        'details' => 'Token is expired',
                    ]
                ]
            ], $this->isHttpException($exception) ? $exception->getStatusCode() : Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof TokenInvalidException) {
            return response()->json([
                'errors' => [
                    [
                        'title' => Str::title(Str::snake(class_basename(
                            $exception
                        ), ' ')),
                        'details' => 'Token is invalid',
                    ]
                ]
            ], $this->isHttpException($exception) ? $exception->getStatusCode() : Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof JWTException) {
            return response()->json([
                'errors' => [
                    [
                        'title' => Str::title(Str::snake(class_basename(
                            $exception
                        ), ' ')),
                        'details' => 'Token is not provided',
                    ]
                ]
            ], $this->isHttpException($exception) ? $exception->getStatusCode() : Response::HTTP_BAD_REQUEST);
        }

        if (
            $exception instanceof QueryException || $exception instanceof
            ModelNotFoundException
        ) {
            $exception = new NotFoundHttpException('Resource not found');
        }

        return parent::render($request, $exception);
    }
}
