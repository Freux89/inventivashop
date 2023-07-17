<?php

namespace App\Http\Controllers\Backend\BlogSystem;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoriesController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:blog_categories'])->only('index');
        $this->middleware(['permission:add_blog_categories'])->only(['store']);
        $this->middleware(['permission:edit_blog_categories'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_blog_categories'])->only(['delete']);
    }

    # unit list
    public function index(Request $request)
    {
        $searchKey = null;
        $categories = BlogCategory::oldest();
        if ($request->search != null) {
            $categories = $categories->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $categories = $categories->paginate(paginationNumber());
        return view('backend.pages.blogSystem.blogCategories.index', compact('categories', 'searchKey'));
    }

    # unit store
    public function store(Request $request)
    {
        $category = new BlogCategory;
        $category->name = $request->name;
        $category->save();

        flash(localize('Category has been inserted successfully'))->success();
        return redirect()->route('admin.blogCategories.index');
    }

    # edit unit
    public function edit(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('backend.pages.blogSystem.blogCategories.edit', compact('category'));
    }

    # update unit
    public function update(Request $request)
    {
        $category = BlogCategory::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();
        flash(localize('Category has been updated successfully'))->success();
        return back();
    }


    # delete unit
    public function delete($id)
    {
        $category = BlogCategory::findOrFail($id);
        Blog::where('blog_category_id', $category->id)->delete();
        $category->delete();
        flash(localize('Category has been deleted successfully'))->success();
        return back();
    }
}
