<?php

namespace App\Providers;

use App\Services\JWTAuth;
use App\Services\JWTGuard as JWTAuthGuard;
use App\Services\TokenProvider;
use App\Services\TokenSource;
use App\Services\TokenStorage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Woodstick\JWT\JWTLib;

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
        
        $this->app->singleton('app.jwt.token.source', function ($app) {
            return new TokenSource();
        });
        
        $this->app->singleton('app.jwt.token.provider', function ($app) {
            $tokenProvider = new TokenProvider(
                $app['request'],
                $app['app.jwt.token.source']
            );
            
            // Refresh an instance of request on the given target and method.
            $this->app->refresh('request', $tokenProvider, 'setRequest');
            
            return $tokenProvider;
        });
        
        $this->app->singleton('app.jwt.token.storage', function ($app) {
            return new TokenStorage();
        });

        $this->app->singleton('app.jwt.service', function ($app) {
            return new JWTAuth(
                $app['app.jwt.library'],
                $app['app.jwt.token.provider'],
                $app['app.jwt.token.storage']
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

        // Define 'axt-jwt' guard
        $this->app['auth']->extend('axt-jwt', function ($app, $name, array $config) {
            
            $provider = $app['auth']->createUserProvider($config['provider']);
            
            $guard = new JWTAuthGuard(
                $app['app.jwt.service'],
                $provider,
                $app['request']
            );
            
            // Refresh an instance of request on the given target and method.
            $this->app->refresh('request', $guard, 'setRequest');

            Log::info('Setup JWT Guard {name}', ["name" => $name]);
            Log::info(sprintf('Setup JWT Guard %s', $name));

            return $guard;
        });
    }
}
