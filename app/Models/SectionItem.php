<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class SectionItem extends Model
{
    protected $fillable = ['section_id', 'position', 'settings'];

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

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('position', 'asc');
        });
    }

    public function getSettingsAttribute($value)
    {
        $decode = json_decode($value, true);
        return json_decode($decode, true);
    }
}
