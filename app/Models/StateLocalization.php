<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateLocalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order_state_id',
        'lang_key',
    ];
}
