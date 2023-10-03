<?php

namespace App\Console\Commands;

use App\Helpers\Google;
use App\Models\User;
use Illuminate\Console\Command;

class FetchMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch workspace members';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $google = new Google();
        $admins = User::where('is_admin', true)
            ->whereNotNull('refresh_token')
            ->groupBy('domain')
            ->get();
        foreach ($admins as $admin) {
            $google->setAccessToken($admin['access_token']);
            $google->setRefreshToken($admin['refresh_token']);
            $domain = $admin['domain'];
            $members = $google->getUsers($domain);
            foreach ($members as $member) {
                $managerId = $google->getGoogleId($google->getManagerEmail($member));
                $user = User::updateOrCreate([
                    'google_id' => $member['id'],
                ], [
                    'email' => $member['primaryEmail'],
                    'given_name' => $member['name']['givenName'],
                    'family_name' => $member['name']['familyName'],
                    'phone' => $member['phones'][0]['value'] ?? null,
                    'avatar' => $member['thumbnailPhotoUrl'] ?? null,
                    'org_title' => $member['organizations'][0]['title'] ?? null,
                    'org_department' => $member['organizations'][0]['department'] ?? null,
                    'manager_id' => $managerId,
                    'is_admin' => !empty($member['isAdmin']),
                    'domain' => $domain,
                ]);
                if (($managerId || $google->hasMember($member['primaryEmail'])) && !$user['show_in_org']) {
                    $user['show_in_org'] = true;
                    $user->save();
                }
            }
        }
    }
}
