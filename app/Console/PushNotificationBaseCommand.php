<?php

namespace App\Console;

use Illuminate\Console\Command;
use Modules\User\Entities\FirebaseToken;
use Modules\Reservation\Entities\Reservation;
use Modules\Notification\Traits\SendNotificationTrait;

class PushNotificationBaseCommand extends Command
{
    use SendNotificationTrait;
    
    public function getAppointments($minutes = 5)
    {
        return Reservation::orderBy('id', 'desc')
        ->wherePaid('paid')
        ->whereBetween('first_time', [now()->subMinutes($minutes), now()])
        ->whereDoesntHave('notifications')
        ->orWhereHas('notifications', function($q) use($minutes)
        {
            return $q->where('sent', '!=', 0)
            ->where('minutes', '!=', $minutes);
        })
        ->take(25)
        ->cursor();
    }

    public function pushNotifications($minutes)
    {
        $title_ar = 'تذكير بموعد الاستشارة';
        $title_en = 'تذكير بموعد الاستشارة';

        $content_ar = 'متبقي من الوقت '.$minutes.' دقائق';
        $content_en = 'متبقي من الوقت '.$minutes.' دقائق';

        $data = [
            'title' => ['ar' => $title_ar, 'en' => $title_en],
            'body' => ['ar' => $content_ar, 'en' => $content_en],
        ];

        $data['type'] = 'general';
        $data['id'] = null;
        
        if( !is_null($appointments = $this->getAppointments($minutes)) )
        {
            foreach($appointments as $appointment)
            {
                $user_token = $this->getUserDeviceToken($appointment->user_id);
                if( is_countable($user_token) && count($user_token) > 0 )
                {
                    if( $user_token['device_type']=='android' )
                    {
                        $this->PushANDROID($data, [$user_token['firebase_token']]);
                    } else if( $user_token['device_type']=='ios' )
                    {
                        $this->PushIOS($data, [$user_token['firebase_token']]);
                    }

                    $appointment->notifications()->updateOrCreate(
                        [
                            'sent' => 1,
                            'minutes' => $minutes,
                        ]
                        );
                }
            }
        }
    }

    public function getUserDeviceToken(int $user_id)
    {
        return FirebaseToken::where('user_id', $user_id)->select('firebase_token', 'device_type', 'lang')->first()->toArray();
    }
}