<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\Category;

class TopCategoriesController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:homepage'])->only('index');
    }

    # top categories
    public function index()
    {
        $categories = Category::latest()->get();
        return view('backend.pages.appearance.homepage.topCategories', compact('categories'));
    }
}
