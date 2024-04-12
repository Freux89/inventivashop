<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;


class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('backend.pages.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('backend.pages.menus.create');
    }

    public function store(StoreMenuRequest $request)
    {
        Menu::create($request->validated());
        return redirect()->route('admin.menus.index')->with('success', 'Menu creato con successo!');

    }

    public function edit(Menu $menu)
    {
        return view('backend.pages.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $menu->update($request->validated());
        return redirect()->route('backend.pages.menus.index');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back();
    }
}