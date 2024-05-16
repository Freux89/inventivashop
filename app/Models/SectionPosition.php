<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class SectionPosition extends Model
{
    protected $fillable = ['section_id', 'positionable_type', 'hook_name', 'order'];
    public $timestamps = false;
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function positionables()
    {
        return $this->hasMany(SectionPositionable::class, 'section_position_id');
    }

    public function positionableEntities()
    {
        switch ($this->positionable_type) {
            case 'Category':
                return $this->belongsToMany(Category::class, 'section_positionables', 'section_position_id', 'positionable_id');
            case 'Product':
                return $this->belongsToMany(Product::class, 'section_positionables', 'section_position_id', 'positionable_id');
            case 'Page':
                return $this->belongsToMany(Page::class, 'section_positionables', 'section_position_id', 'positionable_id');
            default:
                return null;
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }
}
