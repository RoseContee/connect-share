<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request) {
        $userSettings = $request->user()->intranet;
        return view('user.home.settings', [
            'menu' => 'Settings',
            'userSettings' => $userSettings,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'banner_image' => ['nullable', 'image'],
            'rss_link' => ['nullable', 'url'],
        ]);
        $userSettings = $request->user()->intranet;
        if ($request['banner_title']) {
            $userSettings['home_banner_title'] = $request['banner_title'];
        }
        if ($request['rss_link']) {
            $userSettings['rss_link'] = $request['rss_link'];
        }
        if ($request->hasFile('banner_image')) {
            $userSettings->unlinkHomeBanner();
            $userSettings['home_banner_image'] = 'uploads/'.$request->file('banner_image')->store('banner');
        }
        $userSettings->save();
        return back()->with('success_message', 'Settings have been updated.');
    }
}
