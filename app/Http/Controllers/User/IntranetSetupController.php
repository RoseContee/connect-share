<?php

namespace App\Http\Controllers\User;

use App\Helpers\Google;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IntranetSetupController extends Controller
{
    public function users() {
        return view('user.setup.users');
    }

    public function installUsers() {
        $user = auth()->user();
        $domain = $user['domain'];
        $google = new Google($user['access_token'], $user['refresh_token']);
        $members = $google->getUsers($domain);
        foreach ($members as $member) {
            User::updateOrCreate([
                'google_id' => $member['id'],
            ], [
                'email' => $member['primaryEmail'],
                'given_name' => $member['name']['givenName'],
                'family_name' => $member['name']['familyName'],
                'phone' => $member['phones'][0]['value'] ?? null,
                'avatar' => $member['thumbnailPhotoUrl'] ?? null,
                'org_title' => $member['organizations'][0]['title'] ?? null,
                'org_department' => $member['organizations'][0]['department'] ?? null,
                'manager_id' => $google->getGoogleId($google->getManagerEmail($member)),
                'is_admin' => !empty($member['isAdmin']),
                'domain' => $domain,
            ]);
        }
        $user->intranet()->updateOrCreate([
            'domain' => $domain,
        ], [
            'installed' => 1,
        ]);
        return redirect()->route('intranet.setup.complete');
    }

    public function complete() {
        $user = auth()->user();
        $user->intranet()->updateOrCreate([
            'domain' => $user['domain'],
        ], [
            'installed' => 2,
        ]);
        return view('user.setup.complete');
    }
}
