<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Section extends Model
{
    protected $fillable = ['name', 'type', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];


    protected static function booted()
    {
        // Applica il global scope solo se non si è nel backend
        if (!app()->runningInConsole() && !request()->is('admin/*')) {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('is_active', 1);
            });
        }
    }

    public function items()
    {
        return $this->hasMany(SectionItem::class);
    }

    public function getSettingsAttribute($value)
    {
        $decode = json_decode($value, true);
        return json_decode($decode, true);
    }
}
