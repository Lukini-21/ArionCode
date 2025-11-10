<?php

use App\Support\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->group('api', [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \App\Http\Middleware\MockAuthenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    'Validation failed',
                    422,
                    $e->errors()
                );
            }
        });

        // Auth (Gate / Policy)
        $exceptions->render(function (AuthorizationException $e, Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error('Forbidden', 403);
            }
        });

        // Auth (not logged in)
        $exceptions->render(function (AuthenticationException $e, Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error('Unauthenticated', 401);
            }
        });

        // 404 Not Found
        $exceptions->render(function (NotFoundHttpException $e, Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error('Resource not found', 404);
            }
        });

        // Other
        $exceptions->render(function (HttpExceptionInterface $e, Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    $e->getMessage() ?: 'HTTP error',
                    $e->getStatusCode()
                );
            }
        });

        // Fallback — (500, Throwable)
        $exceptions->render(function (Throwable $e, Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                // Можно скрывать stack trace в проде
                $message = config('app.debug')
                    ? $e->getMessage()
                    : 'Server error';

                return ApiResponse::error($message, 500);
            }
        });
    })->create();
