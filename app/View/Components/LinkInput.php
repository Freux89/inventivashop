<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;
use App\Models\Category;

class LinkInput extends Component
{
    public $name;
    public $label;
    public $value;
    public $products;
    public $categories;

    public function __construct($name, $label = null, $value = [], $products = null, $categories = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        
        // Se non sono passati, ottieni i prodotti e le categorie dal database
        $this->products = $products ?? Product::all();
        $this->categories = $categories ?? Category::all();
    }

    public function render()
    {
        return view('components.link-input');
    }
}
