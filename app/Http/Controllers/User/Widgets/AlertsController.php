<?php

namespace App\Http\Controllers\User\Widgets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AlertsController extends Controller
{
    protected string $redirectUrl;

    public function __construct() {
        $this->redirectUrl = route('widget.alerts.auth.google.callback').'/';

        view()->share('menu', 'WidgetAlerts');
    }

    public function index(Request $request) {
        $alert = $request->user()->alert;
        return view('user.home.widgets.alerts.setting', [
            'alert' => $alert,
        ]);
    }

    public function login() {
        return Socialite::driver('google')
            ->redirectUrl($this->redirectUrl)
            ->scopes([
                'https://www.googleapis.com/auth/calendar.readonly',
            ])
            ->with([
                'access_type' => 'offline',
            ])
            ->redirect();
    }

    public function callback(Request $request) {
        $googleUser = Socialite::driver('google')
            ->redirectUrl($this->redirectUrl)
            ->user();
        $googleUser = json_decode(json_encode($googleUser), true);
        logger($googleUser);
        $user = $request->user();
        $alert = $user->alert()
            ->withTrashed()
            ->updateOrCreate([
                'domain' => $user['domain'],
            ], [
                'email' => $googleUser['email'],
                'access_token' => $googleUser['token'],
                'refresh_token' => $googleUser['refreshToken'],
                'deleted_at' => null,
            ]);
        $alert->restore();
        return redirect()->route('widget.alerts')
            ->with('success_message', 'Calendar has been connected.');
    }

    public function destroy(Request $request) {
        if ($alert = $request->user()->alert) {
            $alert->delete();
        }
        return back()->with('error_message', 'The account has been removed.');
    }
}
