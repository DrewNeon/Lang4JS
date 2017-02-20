<?php

namespace DrewNeon\Lang4JS;

use Illuminate\Support\ServiceProvider;

class Lang4JSServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
      $this->loadRoutesFrom(__DIR__.'/routes.php');
      $this->publishes([
          __DIR__.'/assets' => public_path('vendor/lang4js'),
      ], 'public');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->make('DrewNeon\Lang4JS\Lang4JSController');
    }
}
