<?php

namespace App\Http\Controllers\User;

use App\Helpers\Organization;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function members(Request $request) {
        $keyword = $request['q'];
        $users = $request->user()
            ->users()
            ->where(function ($query) use ($keyword) {
                if ($keyword) {
                    $query->orWhere('given_name', 'like', "%{$keyword}%")
                        ->orWhere('family_name', 'like', "%{$keyword}%");
                }
            })->paginate(12)
            ->appends(['q' => $keyword]);
        return view('user.home.people.members', [
            'menu' => 'PeopleMembers',
            'keyword' => $keyword,
            'members' => $users,
        ]);
    }

    public function organization(Request $request) {
        $user = $request->user();
        $organization = new Organization();
        $members = $user->users()->showInOrg()->get();
        $organization->setMembers($members);
        return view('user.home.people.organization', [
            'menu' => 'PeopleOrganization',
            'organization' => [
                'id' => 1,
                'name' => $user['domain'],
                'avatar' => getFavicon(Setting::getSetting('favicon')),
                'children' => $organization->getHierarchyData(),
            ],
        ]);
    }

    public function removeOrganization(Request $request) {
        $request->user()->users()
            ->where('google_id', $request['user'])
            ->update(['show_in_org' => false]);
        return back()->with('info_message', 'Member has been removed from chart.');
    }
}
