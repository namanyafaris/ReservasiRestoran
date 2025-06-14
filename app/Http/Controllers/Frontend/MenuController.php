<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;


class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $menus = Menu::query();

        // Filter kategori
        if ($request->has('categories') && is_array($request->categories)) {
            $menus->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }

        // Urutkan harga
        if ($request->sort == 'asc') {
            $menus->orderBy('price', 'asc');
        } elseif ($request->sort == 'desc') {
            $menus->orderBy('price', 'desc');
        }

        $menus = $menus->get();

        return view('menus.index', compact('menus', 'categories'));
    }

    public function show($id)
{
    $menu = Menu::findOrFail($id);

    return view('menus.show', compact('menu'));
}

}
