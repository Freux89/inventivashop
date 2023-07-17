<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitLocalization extends Model
{ 
    use HasFactory; 
    
    protected $fillable = [
        'name',
        'unit_id',
        'lang_key',
    ];
}
