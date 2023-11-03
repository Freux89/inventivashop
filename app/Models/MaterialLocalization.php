<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLocalization extends Model
{
    

    use HasFactory;
    
    protected $fillable = [
        'name',
        'material_id',
        'lang_key',
    ];
}
