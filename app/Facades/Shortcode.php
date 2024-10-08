<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Shortcode extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\ShortcodeParser::class;
    }
}
