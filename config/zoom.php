<?php

// return [
//     'api_key' => env('ZOOM_API_KEY', '6MrYO19ZTQivSJWkOuWWQg'),
//     'api_secret' => env('ZOOM_API_SECRET', 'vf8M0via50XGsaLV3yNEORsw8f3PlexA'),
//     'account_id' => env('ZOOM_ACCOUNT_ID', '5nguUg02RdmCbW7dWBAVXw'),
//     'base_url' => env('ZOOM_API_URL', 'https://api.zoom.us/v2/'),
//     'token_life' => 60 * 60 * 24 * 7, // In seconds, default 1 week
//     'authentication_method' => 'oauth', // Only jwt compatible at present but will add OAuth2
//     'max_api_calls_per_request' => '5', // how many times can we hit the api to return results for an all() request
//     'approval_type' => 0, // join directly without accepting host
//     'waiting_room' => false, // join directly without accepting host
//     'audio' => 'both',
//     'auto_recording' => 'none',

// ];

return [
    //from v 5.0
    'account_id' => env('ZOOM_ACCOUNT_ID', '6MrYO19ZTQivSJWkOuWWQg'),
    'client_id' => env('ZOOM_CLIENT_ID', 'vf8M0via50XGsaLV3yNEORsw8f3PlexA'),
    'client_secret' => env('ZOOM_CLIENT_SECRET', '5nguUg02RdmCbW7dWBAVXw'),
    'cache_token' => env('ZOOM_CACHE_TOKEN', true),
    'base_url' => env('ZOOM_API_URL', 'https://api.zoom.us/v2/'),
    'authentication_method' => 'Oauth', // Only Oauth compatible at present
    'max_api_calls_per_request' => '5', // how many times can we hit the api to return results for an all() request

     //from v 4.1
    'approval_type' => 0, // join directly without accepting host
    'waiting_room' => false, // join directly without accepting host
    'audio' => 'both',
    'auto_recording' => 'none',

    //after update for SDK mobile iniation
    'client_sdk_id' => env('ZOOM_SDK_CLIENT_ID', 'Bqq_8EzGQBKtLS3vwGaPQ'),
    'client_sdk_secret' => env('ZOOM_SDK_CLIENT_SECRET', 'BG4RgXQZGS43d52s1TIr8T2KuCJJlOLA'),
];
