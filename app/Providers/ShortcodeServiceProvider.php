<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ShortcodeParser;
use Illuminate\Support\Facades\View;

class ShortcodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ShortcodeParser::class, function ($app) {
            return new ShortcodeParser();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ShortcodeParser $shortcodeParser)
    {
        $shortcodeParser->register('section', function ($attributes) {
            $sectionId = $attributes['id'] ?? null;

            if ($sectionId) {
                $section = \App\Models\Section::find($sectionId);
                if ($section) {
                    return View::make('frontend.default.pages.partials.sections.shortcode', ['section' => $section])->render();
                }
            }

            return '';
        });
    }
}
