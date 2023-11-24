<?php

namespace App\Http\Controllers\User;

use App\Helpers\Google;
use App\Helpers\Widgets;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected int $alertsLifetime = 10; //minutes

    public function index(Request $request) {
        $user = $request->user();
        $alerts = [];
        if ($user->hasWidget(Widgets::ALERTS) && ($alert = $user['alert'])) {
            $alerts = Cache::remember($alert['email'].'-alerts', $this->alertsLifetime, function () use ($alert) {
                $google = new Google($alert['access_token'], $alert['refresh_token']);
                $alerts = $google->getEvents($alert['email']);
                $google->saveAuthUserToken($alert);
                return $alerts;
            });
        }
        $myEvents = Cache::remember($user['email'].'-own', $this->alertsLifetime, function () use ($user) {
            $google = new Google($user['access_token'], $user['refresh_token']);
            $myEvents = $google->getEvents($user['email'], $user->hasWidget(Widgets::ALERTS) ? 1 : 3);
            $google->saveAuthUserToken($user);
            return $myEvents;
        });
        return view('user.home.index', [
            'alerts' => $alerts,
            'myEvents' => $myEvents,
        ]);
    }

    public function profile() {
        return view('user.home.profile', [
            'menu' => 'Profile',
        ]);
    }

    public function storageUsage(Request $request) {
        $user = $request->user();
        $google = new Google($user['access_token'], $user['refresh_token']);
        $usage = $google->getStorageUsage();
        $user['drive_usage'] = $usage['drive_usage'];
        $user['gmail_usage'] = $usage['gmail_usage'];
        $user['photos_usage'] = $usage['photos_usage'];
        $user->save();
        $total_usage = $usage['total_usage'];
        return response()->json([
            'total_usage' => byte_formate($total_usage),
            'drive_usage' => byte_formate($user['drive_usage']),
            'gmail_usage' => byte_formate($user['gmail_usage']),
            'photos_usage' => byte_formate($user['photos_usage']),
        ]);
    }
}
