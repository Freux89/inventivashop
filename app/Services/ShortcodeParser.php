<?php

namespace App\Services;

use Illuminate\Support\Facades\View;

class ShortcodeParser
{
    protected $shortcodes = [];

    public function register($shortcode, $callback)
    {
        $this->shortcodes[$shortcode] = $callback;
    }

    public function parse($content)
    {
        foreach ($this->shortcodes as $shortcode => $callback) {
            $pattern = "/\[$shortcode(.*?)\]/";

            $content = preg_replace_callback($pattern, function ($matches) use ($callback) {
                $attributesString = trim($matches[1]);
                $attributes = $this->parseAttributes($attributesString);

                return call_user_func($callback, $attributes);
            }, $content);
        }

        return $content;
    }

    protected function parseAttributes($text)
    {
        $attributes = [];
        preg_match_all('/(\w+)="([^\"]*)"/', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $attributes[$match[1]] = $match[2];
        }

        return $attributes;
    }
}