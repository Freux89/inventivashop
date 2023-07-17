<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationValueLocalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'variation_value_id',
        'lang_key',
    ]; 
}
