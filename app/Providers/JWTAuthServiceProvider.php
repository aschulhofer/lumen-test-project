<?php

namespace App\Providers;

use App\Services\JWTAuth;
use App\Services\JWTGuard as JWTAuthGuard;
use App\Data\Model\User;

use Woodstick\JWT\JWTLib;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Log;

class JWTAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('app.jwt.library', function ($app) {
            return new JWTLib();
        });

        $this->app->singleton('app.jwt.service', function ($app) {
            return new JWTAuth(
                $app['app.jwt.library']
            );
        });
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {

        $this->app['auth']->extend('jwt', function ($app, $name, array $config) {
            $guard = new JWTAuthGuard(
                $app['auth']->createUserProvider($config['provider']),
                app('request')
            );

            Log::info('Setup JWT Guard');

            return $guard;
        });
    }
}
