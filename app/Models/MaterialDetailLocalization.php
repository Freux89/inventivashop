<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDetailLocalization extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'material_detail_id',
        'lang_key',
    ];

    public function materialDetail()
    {
        return $this->belongsTo(MaterialDetail::class);
    }
}
