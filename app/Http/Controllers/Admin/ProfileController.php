<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private string $menu = 'Profile';

    public function __construct() {
        view()->share('menu', $this->menu);
    }

    public function index() {
        return view('admin.profile');
    }

    public function updateEmail(Request $request) {
        $user = auth('admin')->user();
        $request->validateWithBag('email', [
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', 'current_password'],
        ]);
        $user['email'] = $request['email'];
        $user->save();
        return back()->with('success_message', 'Your account email has been updated.');
    }

    public function updatePassword(Request $request) {
        $user = auth('admin')->user();
        $request->validateWithBag('password', [
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);
        $user['password'] = bcrypt($request['password']);
        $user->save();
        return back()->with('success_message', 'Your password has been updated.');
    }
}
