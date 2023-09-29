<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UsefulLink;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct() {
        view()->share('menu', 'Links');
    }

    public function index() {
        $links = auth()->user()
            ->links()
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.home.links.index', [
            'links' => $links,
        ]);
    }

    public function create() {
        return view('user.home.links.add');
    }

    public function store(Request $request) {
        $request->validate([
            'link' => ['required', 'url'],
        ]);
        $user = auth()->user();
        $user->links()->create([
            'domain' => $user['domain'],
            'link' => $request['link'],
            'description' => $request['description'],
        ]);
        return redirect()->route('useful-links.index')->with('success_message', 'New link has been added.');
    }

    public function edit($id) {
        $link = auth()->user()
            ->links()
            ->where('id', $id)
            ->first();
        if (!$link) return back();
        return view('user.home.links.add', [
            'link' => $link,
        ]);
    }

    public function update(Request $request, $id) {
        $link = auth()->user()
            ->links()
            ->where('id', $id)
            ->first();
        if (!$link) return back();
        $request->validate([
            'link' => ['required', 'url'],
        ]);
        $link['link'] = $request['link'];
        $link['description'] = $request['description'];
        $link->save();
        return back()->with('info_message', 'Link has been updated.');
    }

    public function destroy($id) {
        $link = auth()->user()
            ->links()
            ->where('id', $id)
            ->first();
        if (!$link) return back();
        $link->delete();
        return back()->with('error_message', 'Link has been removed.');
    }
}
