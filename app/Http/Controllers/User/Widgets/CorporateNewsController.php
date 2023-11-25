<?php

namespace App\Http\Controllers\User\Widgets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class CorporateNewsController extends Controller
{
    protected string $redirectUrl;

    public function __construct() {
        $this->redirectUrl = route('widget.corporate-news.auth.google.callback').'/';

        view()->share('menu', 'WidgetCorporateNews');
    }

    public function index(Request $request) {
        $corporateNews = $request->user()->corporateNews;
        return view('user.home.widgets.corporate-news.setting', [
            'corporateNews' => $corporateNews,
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
                'approval_prompt' => 'force',
            ])
            ->redirect();
    }

    public function callback(Request $request) {
        $googleUser = Socialite::driver('google')
            ->redirectUrl($this->redirectUrl)
            ->user();
        $googleUser = json_decode(json_encode($googleUser), true);
        $user = $request->user();
        $email = $googleUser['email'];
        $accessToken = $googleUser['token'];
        $refreshToken = $googleUser['refreshToken'];
        if (($email == $user['email']) && !$refreshToken) {
            $refreshToken = $user['refresh_token'];
        }
        $corporateNews = $user->corporateNews()
            ->withTrashed()
            ->updateOrCreate([
                'domain' => $user['domain'],
            ], [
                'email' => $email,
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'deleted_at' => null,
            ]);
        $corporateNews->restore();
        return redirect()->route('widget.corporate-news')
            ->with('success_message', 'Calendar has been connected.');
    }

    public function destroy(Request $request) {
        if ($corporateNews = $request->user()->corporateNews) {
            $corporateNews->delete();
        }
        return back()->with('error_message', 'The account has been removed.');
    }
}
