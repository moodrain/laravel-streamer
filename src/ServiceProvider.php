<?php

namespace Moodrain\LaravelStreamer;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'laravel_streamer');
        $this->app->bind('laravel_streamer', function($app) {
            return new LaravelStreamer(config('laravel_streamer.buffer'));
        });
    }

    public function boot() {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('laravel_streamer.php')
        ]);
    }

}