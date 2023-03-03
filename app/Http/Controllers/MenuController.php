<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $menu = Menu::create($request->all());
        return response()->json($menu);
    }

    public function show($id)
    {
        $menu = Menu::find($id);
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu->update($request->all());
        return response()->json($menu);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return response()->json('deleted');
    }

    public function getTabs($id)
    {
        $menu = Menu::find($id);
        $tabs = $menu->tabs;
        return response()->json($tabs);
    }

    public function addTab(Request $request, $id)
    {
        $menu = Menu::find($id);
        $tab = $menu->tabs()->create($request->all());
        return response()->json($tab);
    }

    public function getTab($id, $tab_id)
    {
        $menu = Menu::find($id);
        $tab = $menu->tabs()->find($tab_id);
        return response()->json($tab);
    }

    public function updateTab(Request $request, $id, $tab_id)
    {
        $menu = Menu::find($id);
        $tab = $menu->tabs()->find($tab_id);
        $tab->update($request->all());
        return response()->json($tab);
    }

    public function deleteTab($id, $tab_id)
    {
        $menu = Menu::find($id);
        $tab = $menu->tabs()->find($tab_id);
        $tab->delete();
        return response()->json('deleted');
    }
}
