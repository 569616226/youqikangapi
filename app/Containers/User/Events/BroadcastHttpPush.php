<?php

namespace App\Containers\User\Events;

use GuzzleHttp\Client;

trait BroadcastHttpPush
{
    public function push($data)
    {
        $baseUrl = env('WEBSOCKET_BASEURL', 'https://echo.elinkport.com:6001/');
        $appId = env('WEBSOCKET_APPID', '681d0064a3e99840');
        $key = env('WEBSOCKET_KEY', '90a6405345c0f7d6b8d0f313addf9268');
        $httpUrl = $baseUrl . 'apps/' . $appId . '/events?auth_key=' . $key;

        $client = new Client([
            'base_uri' => $httpUrl,
            'timeout' => 2.0,
        ]);
        $response = $client->post($httpUrl, [
            'json' => $data
        ]);

        $code = $response->getStatusCode();
    }
}