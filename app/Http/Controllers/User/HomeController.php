<?php

namespace App\Http\Controllers\User;

use App\Helpers\Google;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('user.home.index');
    }

    public function dashboard() {
        return view('user.home.dashboard', [
            'menu' => 'Dashboard',
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
