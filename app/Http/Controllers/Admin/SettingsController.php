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
            /*'logo' => ['nullable', 'image'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required'],*/
        ]);
        Setting::saveSetting([
            'contact_email' => $request['contact_email'],
            'contact_phone' => $request['contact_phone'],
            'shortcut' => !empty($request['shortcut']),
        ]);
        $settings = Setting::getSetting(['favicon', 'logo']);
        if ($request->hasFile('favicon')) {
            if ($settings['favicon'] && file_exists(public_path($settings['favicon']))) {
                unlink(public_path($settings['favicon']));
            }
            $favicon = 'uploads/'.$request->file('favicon')->store('settings');
            Setting::saveSetting('favicon', $favicon);
        }
        /*if ($request->hasFile('logo')) {
            if ($settings['logo'] && file_exists(public_path($settings['logo']))) {
                unlink(public_path($settings['logo']));
            }
            $logo = 'uploads/'.$request->file('logo')->store('settings');
            Setting::saveSetting('logo', $logo);
        }*/
        return back()->with('success_message', 'Settings have been updated.');
    }

    public function updateTheme(Request $request) {
        Setting::saveSetting('dark_mode', $request['darkMode'] == 'true');
        return response()->json([
            'success' => true,
        ]);
    }
}
