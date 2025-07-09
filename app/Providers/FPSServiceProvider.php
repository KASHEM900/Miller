<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class FPSServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $baseurl = env('FPS_BASE_URL');
        $auth = env('FPS_AUTH');
        $username = env('FPS_USERNAME');
        $password = env('FPS_PASSWORD');

        $this->app->singleton('GuzzleHttp\Client', function($api) use ($baseurl, $auth, $username, $password) {
            return new Client([
                'base_uri' => $baseurl,
                'auth' => $auth,
                'username' => $username,
                'password' => $password,
                'verify' => false
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
