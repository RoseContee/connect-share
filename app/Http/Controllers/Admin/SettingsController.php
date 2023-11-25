<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private string $menu = 'Settings';

    public function __construct() {
        view()->share('menu', $this->menu);
    }

    public function index() {
        return view('admin.settings');
    }

    public function store(Request $request) {
        $request->validate([
            'favicon' => ['nullable', 'image'],
            // 'logo' => ['nullable', 'image'],
            'contact_email' => ['required', 'email'],
            // 'contact_phone' => ['required'],
            'home_banner_title' => ['required'],
            'home_banner_image' => ['nullable', 'image'],
            'profile_banner_image' => ['nullable', 'image'],
            'rss_link' => ['required', 'url'],
        ]);
        Setting::saveSetting([
            'contact_email' => $request['contact_email'],
            // 'contact_phone' => $request['contact_phone'],
            'home_banner_title' => $request['home_banner_title'],
            'hide_profile_banner' => !empty($request['hide_banner']),
            'rss_link' => $request['rss_link'],
            'shortcut' => !empty($request['shortcut']),
        ]);
        $settings = Setting::getSetting(['favicon', 'logo', 'profile_banner_image']);
        if ($request->hasFile('favicon')) {
            if (getPath($settings['favicon'])) {
                unlink(public_path($settings['favicon']));
            }
            $favicon = 'uploads/'.$request->file('favicon')->store('settings');
            Setting::saveSetting('favicon', $favicon);
        }
        /*if ($request->hasFile('logo')) {
            if (getPath($settings['logo'])) {
                unlink(public_path($settings['logo']));
            }
            $logo = 'uploads/'.$request->file('logo')->store('settings');
            Setting::saveSetting('logo', $logo);
        }*/
        if ($request->hasFile('home_banner_image')) {
            if (getPath($settings['home_banner_image'])) {
                unlink(public_path($settings['home_banner_image']));
            }
            $banner_image = 'uploads/'.$request->file('home_banner_image')->store('banner');
            Setting::saveSetting('home_banner_image', $banner_image);
        }
        if ($request->hasFile('profile_banner_image')) {
            if (getPath($settings['profile_banner_image'])) {
                unlink(public_path($settings['profile_banner_image']));
            }
            $banner_image = 'uploads/'.$request->file('profile_banner_image')->store('banner');
            Setting::saveSetting('profile_banner_image', $banner_image);
        }
        return back()->with('success_message', 'Settings have been updated.');
    }

    public function updateTheme(Request $request) {
        Setting::saveSetting('dark_mode', $request['darkMode'] == 'true');
        return response()->json([
            'success' => true,
        ]);
    }

    public function updateShowShortcuts(Request $request) {
        Setting::saveSetting('shortcut', $request['show'] == 'true');
        return response()->json([
            'success' => true,
        ]);
    }
}
