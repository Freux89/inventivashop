<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\QuantityDiscountTier;
use App\Models\QuantityDiscount;
use Illuminate\Http\Request;

class QuantityDiscountTierController extends Controller
{
    public function create(QuantityDiscount $quantityDiscount)
    {
        return view('backend.pages.products.quantity_discounts.tiers.create', compact('quantityDiscount'));
    }

    public function store(Request $request, QuantityDiscount $quantityDiscount)
    {
        $data = $request->validate([
            'min_quantity' => 'required|integer|min:1',
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $quantityDiscount->tiers()->create($data);

        return redirect()->route('quantity_discounts.edit', $quantityDiscount->id);
    }


    

    public function delete(QuantityDiscount $quantityDiscount, QuantityDiscountTier $tier)
    {
        $tier->delete();

        return redirect()->route('quantity_discounts.edit', $quantityDiscount->id);
    }
}
