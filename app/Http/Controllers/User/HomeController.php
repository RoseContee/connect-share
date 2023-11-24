<?php

namespace App\Http\Controllers\User;

use App\Helpers\Google;
use App\Helpers\Widgets;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Vedmant\FeedReader\Facades\FeedReader;

class HomeController extends Controller
{
    protected int $alertsLifetime = 60 * 10; //minutes

    public function index() {
        $user = User::with([
            'alert',
            'links' => function ($query) {
                $query->orderBy('updated_at', 'desc')->limit(5);
            }
        ])->find(auth()->id());
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
        $newses = Cache::remember('news', 60 * 30, function () {
            $rss = FeedReader::read('https://www.ansa.it/sito/ansait_rss.xml');
            $items = $rss->get_items();
            $newsItems = [];
            foreach ($items as $index => $item) {
                if ($index === 5) break;
                $newsItems[strtotime($item->get_date())] = [
                    'title' => $item->get_title(),
                    'link' => $item->get_link(),
                    'date' => $item->get_date(),
                ];
            }
            krsort($newsItems);
            $newses = [];
            foreach ($newsItems as $index => $item) {
                if ($index === 5) break;
                $newses[] = $item;
            }
            return $newses;
        });
        return view('user.home.index', [
            'alerts' => $alerts,
            'myEvents' => $myEvents,
            'links' => $user['links'],
            'newses' => $newses,
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
