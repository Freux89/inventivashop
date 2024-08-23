<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTemplateAssignment extends Model
{
    protected $table = 'product_template_assignments';

    // Disabilita i timestamp automatici se non necessari
    public $timestamps = false;

    // Relazione con il modello Template
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    // Relazione con il modello Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
