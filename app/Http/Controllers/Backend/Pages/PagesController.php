<?php

namespace App\Http\Controllers\Backend\Pages;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Page; 
use App\Models\PageLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PagesController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:pages'])->only('index'); 
        $this->middleware(['permission:add_pages'])->only(['create', 'store']);  
        $this->middleware(['permission:edit_pages'])->only(['edit', 'update']);  
        $this->middleware(['permission:delete_pages'])->only(['delete']);  
    }
    
     # page list
     public function index(Request $request)
     {
         $searchKey = null;
         $pages = Page::oldest();
         if ($request->search != null) {
             $pages = $pages->where('title', 'like', '%' . $request->search . '%');
             $searchKey = $request->search;
         }
 
         $pages = $pages->paginate(paginationNumber());
         return view('backend.pages.pages.index', compact('pages', 'searchKey'));
     }

    # return view of create form
    public function create()
    { 
        return view('backend.pages.pages.create');
    }

     # page store
    public function store(Request $request)
    {  
        $page = new Page;
        $page->title = $request->title;
        $page->slug             = Str::slug($request->title);  
        $page->content          = $request->content; 
        $page->meta_title       = $request->meta_title;
        $page->meta_description = $request->meta_description; 
        $page->meta_image       = $request->meta_image; 
  
        $page->save();

        $pageLocalization           = PageLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'page_id' => $page->id]);
        $pageLocalization->title    = $request->title;
        $pageLocalization->content  = $request->content;  
        $pageLocalization->save();

        flash(localize('Page has been created successfully'))->success();
        return redirect()->route('admin.pages.index');
    }

    # edit page
     public function edit(Request $request, $id)
    {
        $lang_key = $request->lang_key;
        $language = Language::isActive()->where('code', $lang_key)->first();
        if(!$language){ 
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.pages.index');
        } 
        $page = Page::findOrFail($id);
        return view('backend.pages.pages.edit', compact('page', 'lang_key'));
    }

    # update page
    public function update(Request $request)
    {  
        $page = Page::findOrFail($request->id); 

        if($request->lang_key == env("DEFAULT_LANGUAGE")){
            $page->title = $request->title; 
            $page->slug = (!is_null($request->slug)) ? Str::slug($request->slug, '-') : Str::slug($request->title, '-');  
         
            $page->content = $request->content;
            
            $page->meta_title = $request->meta_title;
            $page->meta_description = $request->meta_description;  
            $page->meta_image       = $request->meta_image;    
            
            $page->save();  
        } 

        $pageLocalization = PageLocalization::firstOrNew(['lang_key' => $request->lang_key, 'page_id' => $page->id]);
        $pageLocalization->title    = $request->title;
        $pageLocalization->content  = $request->content;  
        $pageLocalization->save();

        $page->save(); 
        $pageLocalization->save(); 
        flash(localize('Page has been updated successfully'))->success();
        return back(); 
    }

    # delete page
    public function delete($id)
    {
        $page = Page::findOrFail($id);  
        $page->delete();  
        flash(localize('Page has been deleted successfully'))->success();
        return back();
    }
    
}
