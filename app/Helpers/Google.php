<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Google
{
    protected ?string $accessToken = null;
    protected ?string $refreshToken = null;
    protected $users;

    public function __construct(string $accessToken = null, string $refreshToken = null) {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    public function setAccessToken(string $accessToken) {
        $this->accessToken = $accessToken;
    }

    public function setRefreshToken(string $refreshToken) {
        $this->refreshToken = $refreshToken;
    }

    protected function refreshAccessToken() {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $this->refreshToken,
            'grant_type' => 'refresh_token',
        ]);
        $result = $response->json();
        if (($this->accessToken = $result['access_token'] ?? null)
            && ($user = auth()->user())
        ) {
            $user['access_token'] = $this->accessToken;
            $user->save();
        }
        return $this->accessToken;
    }

    public function getUser(string $email) {
        for ($i = 0; $i < 2; $i++) {
            $response = Http::withToken($this->accessToken)
                ->get("https://admin.googleapis.com/admin/directory/v1/users/{$email}");
            if (!$response->unauthorized() || (!$i && !$this->refreshAccessToken())) break;
        }
        $user = $response->json();
        return !empty($user['id']) ? $user : null;
    }

    public function getUsers(string $domain) {
        $users = [];
        $pageToken = '';
        do {
            for ($i = 0; $i < 2; $i++) {
                $response = Http::withToken($this->accessToken)
                    ->get('https://admin.googleapis.com/admin/directory/v1/users', [
                        'domain' => $domain,
                        'pageToken' => $pageToken,
                    ]);
                if (!$response->unauthorized() || (!$i && !$this->refreshAccessToken())) break;
            }
            $result = $response->json();
            if ($result['users'] ?? null) {
                $users = array_merge($users, $result['users']);
            }
        } while ($pageToken = $result['nextPageToken'] ?? '');
        $this->users = $users;
        return $users;
    }

    public function getManagerEmail($user) {
        $managerEmail = null;
        foreach ($user['relations'] ?? [] as $relation) {
            if ($relation['type'] == 'manager') {
                $managerEmail = $relation['value'];
                break;
            }
        }
        return $managerEmail;
    }

    public function getGoogleId(string $email = null) {
        try {
            foreach ($this->users as $user) {
                foreach ($user['emails'] as $userEmail) {
                    if ($userEmail['address'] == $email) {
                        return $user['id'];
                    }
                }
            }
        } catch (\Exception $exception) {}
        return null;
    }

    public function hasMember($managerEmail) {
        try {
            foreach ($this->users as $user) {
                foreach ($user['relations'] ?? [] as $relation) {
                    if ($relation['type'] == 'manager' && $relation['value'] == $managerEmail) {
                        return true;
                    }
                }
            }
        } catch (\Exception $exception) {}
        return false;
    }

    public function getStorageUsage() {
        $total_usage = $drive_usage = $gmail_usage = $photos_usage = 0;
        for ($i = 0; $i < 2; $i++) {
            $response = Http::withToken($this->accessToken)
                ->get('https://www.googleapis.com/drive/v2/about');
            if (!$response->unauthorized() || (!$i && !$this->refreshAccessToken())) break;
        }
        $result = $response->json();
        foreach ($result['quotaBytesByService'] ?? [] as $item) {
            $value = $item['bytesUsed'] ?? 0;
            switch (strtoupper($item['serviceName'] ?? '')) {
                case 'DRIVE':
                    $total_usage += ($drive_usage = $value); break;
                case 'GMAIL':
                    $total_usage += ($gmail_usage = $value); break;
                case 'PHOTOS':
                    $total_usage += ($photos_usage = $value); break;
            }
        }
        return [
            'total_usage' => $total_usage,
            'drive_usage' => $drive_usage,
            'gmail_usage' => $gmail_usage,
            'photos_usage' => $photos_usage,
        ];
    }
}
