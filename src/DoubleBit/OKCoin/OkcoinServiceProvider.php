<?php

namespace Doublebit\Okcoin;

use Illuminate\Support\ServiceProvider;

class OkcoinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/okcoin.php' => config_path('okcoin.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('okcoin', 'DoubleBit\OKCoin\Okcoin' );
    }
}
