<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class MenuItem extends Model
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

    // Relazione con il Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Relazione con i MenuColumns
    public function columns()
    {
        return $this->hasMany(MenuColumn::class)->orderBy('position');
    }

    // Relazione con MenuItem per gestire il menu a discesa
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    // Relazione con il prodotto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relazione con la categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}


