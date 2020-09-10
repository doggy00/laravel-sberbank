<?php


namespace SberbankApi;

use GuzzleHttp\Client as HttpClient;
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

        $this->app->when(SberbankApiClient::class)
            ->needs(SberbankApi::class)
            ->give(static function () {
                return new SberbankApi(
                    config('sberbank-api.username'),
                    config('sberbank-api.password'),
                    config('sberbank-api.test'),
                    new HttpClient()
                );
            });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sberbank-api.php', 'sberbank-api'
        );
    }
}