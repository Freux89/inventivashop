<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    protected $fillable = ['name', 'is_primary'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($menu) {
            if ($menu->is_primary) {
                Menu::where('is_primary', true)->update(['is_primary' => false]);
            }
        });
    }
}