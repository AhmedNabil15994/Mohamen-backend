<?php

namespace Modules\Notification\Traits;

use Modules\Notification\Enums\DeviceType;
use Modules\User\Entities\FirebaseToken;
use Modules\User\Entities\UserFireBaseToken;

trait SendNotificationTrait
{
    public function prepareTokens(array $tokens)
    {
        return collect($tokens)->map(function(string $value)
        {
            return trim($value);
        })->reject(function (string $value) {
            return empty($value);
        })
        ->toArray();
    }

    public function send($data, $tokens = null)
    {
        if (is_array($tokens)) {
            $tokens = array_values(array_unique($tokens));
        } else {
            $tokens = array($tokens);
        }

        $tokens = $this->prepareTokens($tokens);

        $ios = FirebaseToken::whereIn('firebase_token', $tokens)
            ->select('firebase_token')
            ->where('device_type', DeviceType::IOS)
            ->groupBy('firebase_token')
            ->pluck('firebase_token');

        $android = FirebaseToken::whereIn('firebase_token', $tokens)
            ->where('device_type', DeviceType::ANDROID)
            ->groupBy('firebase_token')
            ->pluck('firebase_token');

        if ($ios) {
            $regIdIOS = array_chunk(json_decode($ios), 999);
            foreach ($regIdIOS as $tokens) {
                $msg[] = $this->PushIOS($data, $this->prepareTokens($tokens));
            }
        }

        if ($android) {
            $regIdAndroid = array_chunk(json_decode($android), 999);
            foreach ($regIdAndroid as $tokens) {
                $this->PushANDROID($data, $this->prepareTokens($tokens));
            }
        }
    }
    public function sendTranslatedMessageToUser($data, $tokens)
    {
        $ios =$tokens->where('device_type', DeviceType::IOS)->groupBy('lang');
        $androidTokens=$tokens->where('device_type', DeviceType::ANDROID)->groupBy('lang');
        if ($arIos=data_get($ios, 'en', collect())->pluck('firebase_token')) {
            $this->PushIOS($data['ar'], $arIos);
        }
        if ($enIos=data_get($ios, 'ar', collect())->pluck('firebase_token')) {
            $this->PushIOS($data['en'], $enIos);
        }
        if ($arAndroid = data_get($androidTokens, 'en', collect())->pluck('firebase_token')) {
            $this->PushANDROID($data['ar'], $arAndroid);
        }
        if ($enAndroid = data_get($androidTokens, 'ar', collect())->pluck('firebase_token')) {
            $this->PushANDROID($data['en'], $enAndroid);
        }
    }

    public function PushIOS($data, $tokens)
    {
        $notification = [
            'title' => $data['title'][app()->getLocale() ?? 'ar'],
            'body' => $data['body'][app()->getLocale() ?? 'ar'],
            'sound' => 'default',
            'priority' => 'high',
            'badge' => '0',
        ];

        $data = [
            "type" => $data['type'],
            "id" => $data['id'],
        ];

        $fields_ios = [
            'registration_ids' => $tokens,
            'notification' => $notification,
            'data' => $data,
        ];

        return $this->Push($fields_ios);
    }

    public function PushANDROID($data, $tokens)
    {
        $notification = [
            'title' => $data['title'][app()->getLocale() ?? 'ar'],
            'body' => $data['body'][app()->getLocale() ?? 'ar'],
            'sound' => 'default',
            'priority' => 'high',
            "type" => $data['type'],
            "id" => $data['id'],
        ];
        
        $fields_android = [
            'registration_ids' => $tokens,
            'data' => $notification
        ];

        return $this->Push($fields_android);
    }

    public function Push($fields)
    {
        try {
            $url = 'https://fcm.googleapis.com/fcm/send';

            $server_key = env('FCM_SERVER_KEY');

            $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
            );
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === false) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
