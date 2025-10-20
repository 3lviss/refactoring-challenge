<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([
                'message' => $e->getMessage() ?: 'Not Found',
            ], $e->getStatusCode());
        });

        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors'  => $e->errors(),
            ], $e->status);
        });
    })->create();
