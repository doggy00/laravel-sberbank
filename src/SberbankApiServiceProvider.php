<?php


namespace SberbankApi;

use Illuminate\Support\ServiceProvider;

class SberbankApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sberbank-api.php' => config_path('sberbank-api.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sberbank-api.php', 'sberbank-api'
        );
    }
}