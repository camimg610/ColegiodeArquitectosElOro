<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Gates para roles
        Gate::define('gestionar_usuarios', function (User $user) {
            return $user->hasAnyRole(['Administrador']);
        });
        Gate::define('gestionar_inscripciones', function (User $user) {
            return $user->hasAnyRole(['Administrador', 'Usuario']);
        });
        Gate::define('gestionar_eventos', function (User $user) {
            return $user->hasAnyRole(['Administrador', 'Usuario']);
        });
        Gate::define('gestionar_alquileres', function (User $user) {
            return $user->hasAnyRole(['Administrador', 'Usuario']);
        });
        Gate::define('administrar_roles', function (User $user) {
            return $user->hasAnyRole(['Administrador']);
        });
        Gate::define('generar_reportes', function (User $user) {
            return $user->hasAnyRole(['Administrador', 'Usuario']);
        });
    }
}
