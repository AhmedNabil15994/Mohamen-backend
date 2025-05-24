<?php
namespace App\Services;

class ZoomJWTService
{
    static public function generate()
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        $payload = json_encode([
            'appKey' => config('zoom.client_sdk_id'),
            'sdkKey' => config('zoom.client_sdk_id'),
            'role' => '0',
            'iat' => now()->timestamp,
            'exp' => now()->addHours(47)->timestamp,
            'tokenExp' => now()->addHours(47)->timestamp,
        ]);

        $secret = config('zoom.client_sdk_secret');

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);

        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        
        return $jwt;
    }
}