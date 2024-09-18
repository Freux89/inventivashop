<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class MenuColumnItem extends Model
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
    // Relazione con il MenuColumn
    public function menuColumn()
    {
        return $this->belongsTo(MenuColumn::class);
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


