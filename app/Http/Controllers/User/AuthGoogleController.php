<?php

namespace App\Http\Controllers\User;

use App\Helpers\Google;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
    public function login() {
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/admin.directory.user.readonly',
                'https://www.googleapis.com/auth/drive',
            ])->with([
                'access_type' => 'offline',
            ])->redirect();
    }

    public function callback() {
        try {
            $googleUser = Socialite::driver('google')->user();
            $googleUser = json_decode(json_encode($googleUser), true);
            if (!($domain = $googleUser['user']['hd'] ?? null)) {
                return redirect()->route('login')
                    ->with('error_message', 'You do not have access permission.');
            }
            $googleId = $googleUser['id'];
            $email = $googleUser['email'];
            $accessToken = $googleUser['token'];
            $refreshToken = $googleUser['refreshToken'];
            if (!($user = User::where('google_id', $googleId)->first())) {
                $google = new Google($accessToken);
                if ($member = $google->getUser($email)) {
                    $user = User::create([
                        'google_id' => $googleId,
                        'email' => $email,
                        'given_name' => $member['name']['givenName'],
                        'family_name' => $member['name']['familyName'],
                        'phone' => $member['phones'][0]['value'] ?? null,
                        'avatar' => $member['thumbnailPhotoUrl'] ?? null,
                        'org_title' => $member['organizations'][0]['title'] ?? null,
                        'org_department' => $member['organizations'][0]['department'] ?? null,
                        'manager_id' => null,
                        'is_admin' => true,
                        'domain' => $domain,
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken,
                    ]);
                }
            }
            if ($user) {
                $user['access_token'] = $accessToken;
                $user['refresh_token'] = $refreshToken;
                $user->save();
                auth()->login($user);
                return redirect()->route('home');
            }
            $message = 'You do not have access permission. Please contact your administrator.';
        } catch (\Exception $exception) {
            if ($message = $exception->getMessage()) {
                $message = 'Something went wrong. Please try again later.';
            }
        }
        return redirect()->route('login')->with('error_message', $message);
    }
}
