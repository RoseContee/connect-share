<?php

namespace App\Http\Controllers\User;

use App\Helpers\Google;
use App\Http\Controllers\Controller;
use App\Mail\DomainRequest;
use App\Models\Domain;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
    public function login() {
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/admin.directory.user',
                'https://www.googleapis.com/auth/admin.directory.orgunit.readonly',
                'https://www.googleapis.com/auth/drive',
                'https://www.googleapis.com/auth/calendar.readonly',
            ])
            ->with([
                'access_type' => 'offline',
            ])
            ->redirect();
    }

    public function callback() {
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
        $google = new Google($accessToken);
        $user = User::where('google_id', $googleId)->first();
        $intranet = Domain::domain($domain)->first();
        if ((!$user && !($member = $google->getUser($email)))
            || ($user && !$user['is_admin']
                && in_array($intranet['status'] ?? 'blocked', ['pending', 'blocked']))
        ) {
            return redirect()->route('login')
                ->with('error_message', 'You do not have access permission. Please contact your administrator.');
        }
        if (!$user || $user['is_admin']) { //Workspace Admin
            if (!$intranet) {
                if ($contact_email = Setting::getSetting('contact_email')) {
                    try {
                        $intranet = Domain::create([
                            'domain' => $domain,
                            'token' => Str::random(32),
                            'requested_email' => $email,
                            'status' => 'pending',
                        ]);
                        Mail::to($contact_email)->send(new DomainRequest([
                            'domain' => $domain,
                            'url' => route('admin.domains.request', $intranet['token']),
                        ]));
                        return redirect()->route('login')
                            ->with('info_message', 'Your request has been submitted. We will get back to you soon.');
                    } catch (\Exception $exception) {
                    }
                }
                return redirect()->route('login')
                    ->with('error_message', 'Something went wrong. Please try again later.');
            }
            if ($intranet['status'] == 'pending') {
                return redirect()->route('login')
                    ->with('info_message', 'We are reviewing your request. We will get back to you soon. Thank you!');
            }
            if ($intranet['status'] == 'blocked') {
                return redirect()->route('login')
                    ->with('error_message', 'Your domain has been blocked. Please contact your administrator.');
            }
        }
        if ($user) {
            $user['access_token'] = $accessToken;
            if ($refreshToken) {
                $user['refresh_token'] = $refreshToken;
            }
            $user->save();
        } else {
            $user = User::create([
                'google_id' => $googleId,
                'email' => $email,
                'given_name' => $member['name']['givenName'],
                'family_name' => $member['name']['familyName'],
                'phone' => $member['phones'][0]['value'] ?? null,
                'avatar' => $member['thumbnailPhotoUrl'] ?? null,
                'org_title' => $member['organizations'][0]['title'] ?? null,
                'org_department' => $member['organizations'][0]['department'] ?? null,
                'is_admin' => true,
                'domain' => $domain,
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ]);
        }
        auth()->login($user);
        return redirect()->route('home');
    }
}
