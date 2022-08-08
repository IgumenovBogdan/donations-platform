<?php

namespace App\Providers;

use App\Services\PaypalService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaypalService::class, function (Application $app) {
            $config = $app['config']['services']['paypal'];
            return new PaypalService(new Client(), $config['secret'], $config['client_id'], $config['redirect_url']);
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
