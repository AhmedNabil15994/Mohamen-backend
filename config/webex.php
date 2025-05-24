<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base url
    |--------------------------------------------------------------------------
    |
    | Base url for any api request.
    |
    */
    'base_url' => 'https://webexapis.com/v1/',

    /*
    |--------------------------------------------------------------------------
    | Bearer
    |--------------------------------------------------------------------------
    |
    | Bearer token to authenticate requests.
    |
    */
    'bearer' => env('WEBEX_BEARER', 'YmJmOThhMzEtY2FhNi00Mjc4LThkOTItMGQ3Yzg1YTlhMTg0ZGQ3MWEwNTAtZDMy_PE93_d0a60548-d257-4968-b7cc-b4ec8ac374d4'),

    /*
    |--------------------------------------------------------------------------
    | Access Token Request
    |--------------------------------------------------------------------------
    |
    | Access token suffix to make request.
    | Gran type for request body
    |
    */
    'access_token' => [
        'url' => 'access_token',
        'grant_type' => 'authorization_code'
    ],

    /*
    |--------------------------------------------------------------------------
    | Access Token Request
    |--------------------------------------------------------------------------
    |
    | Refresh token suffix to make request.
    | Gran type for request body
    |
    */
    'refresh_token' => [
        'url' => 'refresh_token',
        'grant_type' => 'refresh_token'
    ],

    /*
    |--------------------------------------------------------------------------
    | Client information
    |--------------------------------------------------------------------------
    |
    | Information about web integration client
    |
    */
    'client' => [
        'id' => '',
        'secret' => '',
        'code' => ''
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect uri
    |--------------------------------------------------------------------------
    |
    | Redirect url
    |
    */
    'redirect_uri' => ''
];
