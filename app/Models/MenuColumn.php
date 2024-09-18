<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class MenuColumn extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        // Applica l'ordinamento di default per 'position'
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('position');
        });
    }
    // Relazione con il MenuItem
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    // Relazione con MenuColumnItems
    public function items()
    {
        return $this->hasMany(MenuColumnItem::class)->orderBy('position');;
    }
}


