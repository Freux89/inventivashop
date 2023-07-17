<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandLocalization extends Model
{ 
    use HasFactory; 
    
    protected $fillable = [
        'name',
        'brand_id',
        'lang_key',
    ];
}
