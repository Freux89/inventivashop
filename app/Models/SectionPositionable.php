<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class SectionPositionable extends Model
{
    protected $fillable = ['section_position_id', 'positionable_id'];
    protected $table = 'section_positionables';
    
    // Relazione inversa
    public function sectionPosition()
    {
        return $this->belongsTo(SectionPosition::class, 'section_position_id');
    }
}
