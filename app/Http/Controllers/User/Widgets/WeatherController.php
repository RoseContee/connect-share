<?php

namespace App\Http\Controllers\User\Widgets;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function cities(Request $request) {
        $cities = [];
        try {
            $q = $request['q'];
            if (strlen($q) > 1) {
                $client = new Client();
                $response = $client->get('https://www.booked.net/', [
                    'headers' => [
                        'accept' => 'application/json',
                    ],
                    'query' => [
                        'page' => 'weather_cities_json',
                        'langID' => 1,
                        'q' => $q,
                    ],
                ]);
                $results = json_decode($response->getBody(), true)['results'];
                foreach ($results as $result) {
                    $city = [];
                    if (!empty($result['n'])) $city[] = $result['n'];
                    if (!empty($result['s'])) $city[] = $result['s'];
                    if (!empty($result['c'])) $city[] = $result['c'];
                    $cities[] = [
                        'id' => $result['id'],
                        'cnt' => $result['cnt'],
                        'city' => $result['n'] ?? '',
                        'full_city' => implode(', ', $city),
                    ];
                }
            }
        } catch (\Exception $exception) {
        }
        return response()->json($cities);
    }
}
