<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationLocalization extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'alias',
        'variation_id',
        'lang_key',
    ];
}
