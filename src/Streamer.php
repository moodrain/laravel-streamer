<?php

namespace Moodrain\LaravelStreamer;

use Illuminate\Support\Facades\Facade;

class Streamer extends Facade {

    protected static function getFacadeAccessor() {
        return 'laravel_streamer';
    }

}