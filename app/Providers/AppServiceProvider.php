<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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
        /**
         * 1. FORZAR HTTPS EN PRODUCCIÓN
         * Esto corrige el error "Estás a punto de enviar información no segura" 
         * al obligar a Laravel a generar todas las URLs con HTTPS.
         */
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        /**
         * 2. Headers de seguridad HTTP globales
         */
        Response::macro('secure', function ($value = '', $status = 200, array $headers = []) {
            $headers = array_merge([
                'X-Frame-Options' => 'SAMEORIGIN',
                'X-Content-Type-Options' => 'nosniff',
                'Referrer-Policy' => 'strict-origin-when-cross-origin',
                'X-XSS-Protection' => '1; mode=block',
                'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
            ], $headers);
            return response($value, $status, $headers);
        });

        /**
         * 3. Middleware global para headers
         */
        Route::middlewareGroup('secure-headers', [function ($request, $next) {
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
