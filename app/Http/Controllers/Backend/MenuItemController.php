<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Menu;

class MenuItemController extends Controller
{
    public function index(Menu $menu)
    {
        return view('backend.pages.menus.items.index', compact('menu'));
    }

    public function create(Menu $menu)
    {
        $menuItems = $menu->items()->whereNull('parent_id')->get();
        return view('backend.pages.menus.items.create', compact('menu', 'menuItems'));
    }

    public function store(Request $request, Menu $menu)
    {
        $menu->items()->create($request->validated());
        return redirect()->route('backend.pages.menus.items.index', $menu);
    }

    public function edit(Menu $menu, MenuItem $menuItem)
    {
        $menuItems = $menu->items()->whereNull('parent_id')->get()->except($menuItem->id);
        return view('backend.pages.menus.items.edit', compact('menu', 'menuItem', 'menuItems'));
    }

    public function update(Request $request, Menu $menu, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());
        return redirect()->route('backend.pages.menus.items.index', $menu);
    }

    public function destroy(Menu $menu, MenuItem $menuItem)
    {
        $menuItem->delete();
        return back();
    }
}