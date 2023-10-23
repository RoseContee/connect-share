<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login() {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (auth('admin')->attempt($credentials, !!$request['remember'])) {
            return redirect()->route(RouteServiceProvider::ADMIN_HOME);
        }
        return back()->withInput()->withErrors(['email' => [__('auth.failed')]]);
    }

    public function forgot() {
        return view('admin.auth.forgot-password');
    }

    public function postForgot(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
        ]);
        ResetPassword::createUrlUsing(function (Admin $admin, string $token) {
            return route('admin.password.reset', [
                'token' => $token,
                'email' => $admin['email'],
            ]);
        });
        $status = Password::broker('admins')->sendResetLink($credentials);
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['success_message' => __($status)]);
        }
        return back()->withErrors(['email' => [__($status)]])->onlyInput('email');
    }

    public function reset(string $token) {
        return view('admin.auth.reset-password', [
            'token' => $token
        ]);
    }

    public function postReset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Admin $admin, string $password) {
                $admin->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));
                $admin->save();
                //event(new PasswordReset($admin));
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')->with('success_message', __($status));
        }
        return back()->withErrors(['email' => [__($status)]])->onlyInput('email');
    }
}
