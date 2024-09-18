<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Http\Requests\StoreMenuRequest;


class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::paginate(10);
        return view('backend.pages.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('backend.pages.menus.create');
    }

    public function store(Request $request)
    {
        // Validazione dei dati
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Controllo se il menu deve essere impostato come principale
        if ($request->has('is_main')) {
            // Imposta tutti i menu esistenti come non principali
            Menu::where('is_main', true)->update(['is_main' => false]);
        }

        // Crea il nuovo menu
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->is_main = $request->has('is_main'); // Imposta come principale se selezionato
        $menu->save();

        return redirect()->route('admin.menus.index')->with('success', localize('Menu aggiunto con successo!'));
    }

    public function edit($id)
    {
        // Recupera il menu da modificare
        $menu = Menu::findOrFail($id);

        // Recupera tutti i menu items associati a questo menu
        $menuItems = MenuItem::where('menu_id', $id)->get();

        return view('backend.pages.menus.edit', compact('menu', 'menuItems'));
    }

    public function update(Request $request, Menu $menu)
    {
        $menu->update($request->validated());
        return redirect()->route('backend.pages.menus.index');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return back();
    }
}