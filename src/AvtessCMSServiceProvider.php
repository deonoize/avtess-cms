<?php

namespace Deonoize\AvtessCMS;


use Illuminate\Support\ServiceProvider;

class AvtessCMSServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'avtess_cms');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'avtess_cms');

        $this->publishes(
            [
                __DIR__.'/../config/config.php' => config_path('avtess_cms.php'),
            ],
            'config'
        );
    }
}
