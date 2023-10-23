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

    public function index(Request $request) {
        $links = $request->user()
            ->links()
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.home.links.index', [
            'links' => $links,
        ]);
    }

    public function create(Request $request) {
        if (!$request->user()->is_admin) {
            return redirect()->route('useful-links.index');
        }
        return view('user.home.links.add');
    }

    public function store(Request $request) {
        $user = $request->user();
        if (!$user['is_admin']) {
            return redirect()->route('useful-links.index');
        }
        $request->validate([
            'link' => ['required', 'url'],
        ]);
        $user->links()->create([
            'domain' => $user['domain'],
            'link' => $request['link'],
            'description' => $request['description'],
        ]);
        return redirect()->route('useful-links.index')->with('success_message', 'New link has been added.');
    }

    public function edit(Request $request, $id) {
        $user = $request->user();
        if (!$user['is_admin']
            || !($link = $user->links()->where('id', $id)->first())
        ) {
            return redirect()->route('useful-links.index');
        }
        return view('user.home.links.add', [
            'link' => $link,
        ]);
    }

    public function update(Request $request, $id) {
        $user = $request->user();
        if (!$user['is_admin']
            || !($link = $user->links()->where('id', $id)->first())
        ) {
            return redirect()->route('useful-links.index');
        }
        $request->validate([
            'link' => ['required', 'url'],
        ]);
        $link['link'] = $request['link'];
        $link['description'] = $request['description'];
        $link->save();
        return back()->with('info_message', 'Link has been updated.');
    }

    public function destroy(Request $request, $id) {
        $user = $request->user();
        if (!$user['is_admin']
            || !($link = $user->links()->where('id', $id)->first())
        ) {
            return redirect()->route('useful-links.index');
        }
        $link->delete();
        return back()->with('error_message', 'Link has been removed.');
    }
}
