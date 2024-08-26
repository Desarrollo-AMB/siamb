<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('ver-reporte-agenda', function ($user) {
            return $user->hasRole('aviacion_dao|administrador');
        });
        Gate::define('programacion', function ($user) {
            return $user->hasRole('aviacion_grupo_aereo');
        });
        Gate::define('modificar', function ($user) {
            return $user->hasRole('administrador');
        });
        //
    }
}
