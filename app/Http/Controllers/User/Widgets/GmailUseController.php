<?php

namespace App\Http\Controllers\User\Widgets;

use App\Helpers\Google;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class GmailUseController extends Controller
{
    protected string $membersKey = 'gmail-use-members';
    protected string $orgunitsKey = 'gmail-use-orgunits';

    public function __construct() {
        view()->share('menu', 'WidgetGmailUse');
    }

    public function index(Request $request) {
        Cache::forget($this->membersKey);
        Cache::forget($this->orgunitsKey);
        $user = $request->user();
        $google = new Google($user['access_token'], $user['refresh_token']);
        $members = Cache::remember($this->membersKey, 3600, function () use ($user, $google) {
            return $google->getUsers($user['domain']);
        });
        $orgunits = Cache::remember($this->orgunitsKey, 3600, function () use ($google) {
            return $google->getOrgunits();
        });
        return view('user.home.widgets.gmail-use', [
            'members' => $members,
            'orgunits' => $orgunits,
        ]);
    }

    public function update(Request $request) {
        $user = $request->user();
        $google = new Google($user['access_token'], $user['refresh_token']);
        $members = Cache::remember($this->membersKey, 3600, function () use ($user, $google) {
            return $google->getUsers($user['domain']);
        });
        $emails = [];
        foreach ($members as $member) {
            $emails[] = $member['primaryEmail'];
        }
        $orgunits = Cache::remember($this->orgunitsKey, 3600, function () use ($google) {
            return $google->getOrgunits();
        });
        $rule = [
            'members' => ['required', 'array'],
            'members.*' => ['email', 'in:'.implode(',', $emails)],
            'organisational_unit' => ['required', 'in:'.implode(',', array_keys($orgunits))],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->with('error_message', 'Select the members and organisational unit you want to change.');
        }
        $google->updateOrgunits($request['members'], $request['organisational_unit']);
        return back()->with('success_message', 'Updated organisational unit successfully.');
    }
}
