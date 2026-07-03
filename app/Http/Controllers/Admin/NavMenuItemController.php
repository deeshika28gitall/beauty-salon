<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavMenuItem;
use Illuminate\Http\Request;

class NavMenuItemController extends Controller
{
    public function index()
    {
        return view('admin.nav-menu-items.index', [
            'items' => NavMenuItem::orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.nav-menu-items.form', ['item' => new NavMenuItem()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['open_in_new_tab'] = $request->boolean('open_in_new_tab');

        NavMenuItem::create($data);

        return redirect()->route('admin.nav-menu-items.index')->with('success', 'Menu item created.');
    }

    public function edit(NavMenuItem $navMenuItem)
    {
        return view('admin.nav-menu-items.form', ['item' => $navMenuItem]);
    }

    public function update(Request $request, NavMenuItem $navMenuItem)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['open_in_new_tab'] = $request->boolean('open_in_new_tab');

        $navMenuItem->update($data);

        return redirect()->route('admin.nav-menu-items.index')->with('success', 'Menu item updated.');
    }

    public function destroy(NavMenuItem $navMenuItem)
    {
        $navMenuItem->delete();

        return redirect()->route('admin.nav-menu-items.index')->with('success', 'Menu item deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:120'],
            'href' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
