<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    protected string $menu = 'Shortcuts';

    public function __construct() {
        view()->share('menu', $this->menu);
    }

    public function index() {
        $shortcuts = Shortcut::get();
        return view('admin.shortcuts.index', [
            'shortcuts' => $shortcuts,
        ]);
    }

    public function create() {
        return view('admin.shortcuts.add');
    }

    public function store(Request $request) {
        $request->validate([
            'icon' => ['required', 'image'],
            'title' => ['required'],
            'link' => ['required', 'url'],
        ]);
        $shortcut = new Shortcut();
        if ($request->hasFile('icon')) {
            $shortcut['icon'] = 'uploads/'.$request->file('icon')->store('side-icons');
        }
        $shortcut['title'] = $request['title'];
        $shortcut['link'] = $request['link'];
        $shortcut['active'] = !empty($request['status']);
        $shortcut->save();
        return redirect()->route('admin.shortcuts.index')->with('success_message', 'New shortcut has been added.');
    }

    public function edit($id) {
        $shortcut = Shortcut::find($id);
        if (!$shortcut) return back();
        return view('admin.shortcuts.add', [
            'shortcut' => $shortcut,
        ]);
    }

    public function update(Request $request, $id) {
        $shortcut = Shortcut::find($id);
        if (!$shortcut) return back();
        $request->validate([
            'icon' => ['nullable', 'image'],
            'title' => ['required'],
            'link' => ['required', 'url'],
        ]);
        if ($request->hasFile('icon')) {
            if (getPath($shortcut['icon'])) {
                unlink(public_path($shortcut['icon']));
            }
            $shortcut['icon'] = 'uploads/'.$request->file('icon')->store('side-icons');
        }
        $shortcut['title'] = $request['title'];
        $shortcut['link'] = $request['link'];
        $shortcut['active'] = !empty($request['status']);
        $shortcut->save();
        return back()->with('info_message', 'Shortcut has been updated.');
    }

    public function destroy($id) {
        $shortcut = Shortcut::find($id);
        if (!$shortcut) return back();
        if (getPath($shortcut['icon'])) {
            unlink(public_path($shortcut['icon']));
        }
        $shortcut->delete();
        return redirect()->route('admin.shortcuts.index')->with('error_message', 'Shortcut has been removed.');
    }
}
