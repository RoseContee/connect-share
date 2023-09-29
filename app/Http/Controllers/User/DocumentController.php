<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct() {
        view()->share('menu', 'Documents');
    }

    public function index() {
        $documents = auth()->user()
            ->documents()
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.home.documents.index', [
            'documents' => $documents,
        ]);
    }

    public function create() {
        return view('user.home.documents.add');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => ['required'],
            'link' => ['required', 'url'],
        ]);
        $user = auth()->user();
        $user->documents()->create([
            'domain' => $user['domain'],
            'title' => $request['title'],
            'link' => $request['link'],
            'description' => $request['description'],
        ]);
        return redirect()->route('documents.index')->with('success_message', 'New document has been added.');
    }

    public function edit($id) {
        $document = auth()->user()
            ->documents()
            ->where('id', $id)
            ->first();
        if (!$document) return back();
        return view('user.home.documents.add', [
            'document' => $document,
        ]);
    }

    public function update(Request $request, $id) {
        $document = auth()->user()
            ->documents()
            ->where('id', $id)
            ->first();
        if (!$document) return back();
        $request->validate([
            'title' => ['required'],
            'link' => ['required', 'url'],
        ]);
        $document['title'] = $request['title'];
        $document['link'] = $request['link'];
        $document['description'] = $request['description'];
        $document->save();
        return back()->with('info_message', 'Document has been updated.');
    }

    public function destroy($id) {
        $document = auth()->user()
            ->documents()
            ->where('id', $id)
            ->first();
        if (!$document) return back();
        $document->delete();
        return back()->with('error_message', 'Document has been removed.');
    }
}
