<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Headers de seguridad HTTP globales
        \Illuminate\Support\Facades\Response::macro('secure', function ($value = '', $status = 200, array $headers = []) {
            $headers = array_merge([
                'X-Frame-Options' => 'SAMEORIGIN',
                'X-Content-Type-Options' => 'nosniff',
                'Referrer-Policy' => 'strict-origin-when-cross-origin',
                'X-XSS-Protection' => '1; mode=block',
                'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
            ], $headers);
            return response($value, $status, $headers);
        });

        // Middleware global para headers
        \Illuminate\Support\Facades\Route::middlewareGroup('secure-headers', [function ($request, $next) {
            $response = $next($request);
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            return $response;
        }]);
    }
}
