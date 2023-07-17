<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLocalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_id',
        'lang_key',
    ];
}
