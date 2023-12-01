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
        $user = $request->user();
        $google = new Google($user['access_token'], $user['refresh_token']);
        $members = $google->getUsers($user['domain']);
        $orgunits = $google->getOrgunits();
        Cache::put($this->membersKey, $members);
        Cache::put($this->orgunitsKey, $orgunits);
        return view('user.home.widgets.gmail-use', [
            'members' => $members,
            'orgunits' => $orgunits,
        ]);
    }

    public function update(Request $request) {
        $user = $request->user();
        $google = new Google($user['access_token'], $user['refresh_token']);
        $members = Cache::get($this->membersKey, []);
        $orgunits = Cache::get($this->orgunitsKey, []);
        if (empty($members) || empty($orgunits)) {
            return back()->with('error_message', 'Something went wrong.');
        }
        $emails = [];
        foreach ($members as $member) {
            $emails[] = $member['primaryEmail'];
        }
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
