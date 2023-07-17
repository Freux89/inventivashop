<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\Product;

class BannerSectionTwoController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:homepage'])->only('index');
    }

    # best deal products
    public function index()
    {
        $products = Product::isPublished()->get();
        return view('backend.pages.appearance.homepage.bannerSectionTwo', compact('products'));
    }
}
