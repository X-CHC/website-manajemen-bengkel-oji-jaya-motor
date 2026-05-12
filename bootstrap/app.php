<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Menangkap error ketika user memaksa masuk tanpa login
        $exceptions->render(function (AuthenticationException $e, Request $request) {

            // Cek jika requestnya dari API, kembalikan JSON (Opsional tapi Best Practice)
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Silakan login terlebih dahulu.'], 401);
            }

            // Tendang kembali ke rute login dan bawa pesan 'error' di dalam session
            return redirect()->route('login')
                ->with('error', 'Akses ditolak! Silakan login terlebih dahulu.');

        });

    })->create();
