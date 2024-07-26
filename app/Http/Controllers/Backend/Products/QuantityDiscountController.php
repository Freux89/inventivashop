<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\QuantityDiscount;
use Illuminate\Http\Request;
use App\Models\Product;

class QuantityDiscountController extends Controller
{
    public function index(Request $request)
{
    $searchKey = $request->get('search', '');
    $quantityDiscounts = QuantityDiscount::where('name', 'like', "%{$searchKey}%")
        ->paginate(10);

    return view('backend.pages.products.quantity_discounts.index', compact('quantityDiscounts', 'searchKey'));
}

    public function create()
    {
        $products = Product::all();
        return view('backend.pages.products.quantity_discounts.create', compact('products'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
        'product_ids' => 'array',
        'product_ids.*' => 'exists:products,id',
    ]);

    $discount = QuantityDiscount::create($data);

    if (!empty($data['product_ids'])) {
        // Rimuovi i prodotti dagli sconti precedenti
        foreach ($data['product_ids'] as $productId) {
            $product = Product::find($productId);
            if ($product && $product->quantityDiscounts()->exists()) {
                $product->quantityDiscounts()->detach();
            }
        }
        // Associa i prodotti al nuovo sconto
        $discount->products()->attach($data['product_ids']);
    }

        return redirect()->route('quantity_discounts.index');
    }

    public function edit(QuantityDiscount $quantityDiscount)
    {
        $products = Product::all();
        return view('backend.pages.products.quantity_discounts.edit', compact('quantityDiscount', 'products'));
    }

    public function update(Request $request, QuantityDiscount $quantityDiscount)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
        'product_ids' => 'array',
        'product_ids.*' => 'exists:products,id',
    ]);

    $quantityDiscount->update($data);

    if (isset($data['product_ids'])) {
        // Rimuovi i prodotti dagli sconti precedenti
        foreach ($data['product_ids'] as $productId) {
            $product = Product::find($productId);
            if ($product && $product->quantityDiscounts()->exists()) {
                $product->quantityDiscounts()->detach();
            }
        }
        // Associa i prodotti al nuovo sconto
        $quantityDiscount->products()->sync($data['product_ids']);
    } else {
        $quantityDiscount->products()->detach();
    }

        return redirect()->route('quantity_discounts.index');
    }

   

    public function delete($id)
    {
        $quantityDiscount = QuantityDiscount::findOrFail($id);

    // Rimuovi le associazioni con i prodotti prima di eliminare lo sconto
    $quantityDiscount->products()->detach();

    // Ora puoi eliminare lo sconto senza violare il vincolo di integrità referenziale
    $quantityDiscount->delete();

    flash(localize('Sconto quantità eliminato con successo'))->success();
    return back();
    }
}
