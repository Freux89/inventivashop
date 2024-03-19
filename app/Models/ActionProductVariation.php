<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionProductVariation extends Model
{
    protected $fillable = ['action_id', 'product_variation_id'];
}
