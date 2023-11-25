<?php

namespace App\Http\Controllers\User;

use App\Helpers\Google;
use App\Helpers\Widgets;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Vedmant\FeedReader\Facades\FeedReader;

class HomeController extends Controller
{
    protected int $alertsLifetime = 60 * 10; //minutes

    public function index() {
        $user = User::with([
            'corporateNews',
            'links' => function ($query) {
                $query->orderBy('updated_at', 'desc')->limit(5);
            },
            'intranet',
        ])->find(auth()->id());
        $corporateNewses = [];
        if ($user->hasWidget(Widgets::CORPORATE_NEWS) && ($corporate = $user['corporateNews'])) {
            $corporateNewses = Cache::remember($corporate['email'].'-corporate', $this->alertsLifetime, function () use ($corporate) {
                $google = new Google($corporate['access_token'], $corporate['refresh_token']);
                $corporateNewses = $google->getEvents($corporate['email']);
                $google->saveAuthUserToken($corporate);
                return $corporateNewses;
            });
        }
        $myEvents = Cache::remember($user['email'].'-own', $this->alertsLifetime, function () use ($user) {
            $google = new Google($user['access_token'], $user['refresh_token']);
            $myEvents = $google->getEvents($user['email'], $user->hasWidget(Widgets::CORPORATE_NEWS) ? 1 : 3);
            $google->saveAuthUserToken($user);
            return $myEvents;
        });
        $default_rss_link = Setting::getSetting('rss_link');
        $rss_link = $user['intranet']['rss_link'] ?? $default_rss_link;
        $newses = Cache::remember('news-'.$rss_link, 60 * 30, function () use ($rss_link) {
            if (!$rss_link) return [];
            $rss = FeedReader::read($rss_link);
            $items = $rss->get_items();
            $newsItems = [];
            foreach ($items as $item) {
                $newsItems[strtotime($item->get_date())] = [
                    'title' => $item->get_title(),
                    'link' => $item->get_link(),
                    'date' => $item->get_date(),
                ];
            }
            krsort($newsItems);
            $newses = []; $i = 0;
            foreach ($newsItems as $item) {
                $newses[] = $item;
                if ($i++ === 5) break;
            }
            return $newses;
        });
        return view('user.home.index', [
            'corporateNewses' => $corporateNewses,
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
