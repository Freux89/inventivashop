<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionGroup extends Model
{
    protected $fillable = ['product_id','name'];
    // Definisci la relazione con il modello Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Se hai condizioni legate a questo gruppo, puoi definire anche quella relazione
    public function conditions()
    {
        return $this->hasMany(Condition::class);
    }

    public function template()
{
    return $this->hasOne(Template::class, 'condition_group_id');
}
}
