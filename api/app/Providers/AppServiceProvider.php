<?php

namespace App\Providers;

use App\Services\GuzzleHttpService;
use App\Services\PaypalService;
use App\Services\StripeService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;

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
            return new PaypalService($config['secret'], $config['client_id'], $config['redirect_url'], new GuzzleHttpService(new Client()));
        });
        $this->app->bind(StripeService::class, function (Application $app) {
            $config = $app['config']['services']['stripe'];
            return new StripeService(new StripeClient($config['secret_key']), $config['secret_key']);
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
