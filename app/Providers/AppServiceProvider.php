<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Binding Profile
        $this->app->bind(
            \App\Repositories\Profiles\ProfilesRepositoryInterface::class,
            \App\Repositories\Profiles\ProfilesRepositoryEloquent::class,
        );

        // Binding Service
        $this->app->bind(
            \App\Repositories\Services\ServicesRepositoryInterface::class,
            \App\Repositories\Services\ServicesRepositoryEloquent::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        FacadesValidator::extend('cpf', '\App\Utils\UtilsValidation@validateCpf');
        FacadesValidator::extend('celPhone', '\App\Utils\UtilsValidation@validatePhone');
    }
}
