<?php

namespace Modules\Reservation\Traits;

use App\Services\ZoomService;
use MacsiDigital\Zoom\Facades\Zoom;

trait MeetingZoomTrait
{
    // public function createMeeting($data)
    // {
    //     $user = Zoom::user()->first();
    //     $meeting = Zoom::meeting()->make($data['meeting']);
    //     $meeting->settings()->make($data['setting']);
    //     return $user->meetings()->save($meeting);
    // }

    public function createMeeting($data)
    {
        $start_time = $data['meeting']['start_time'];
        $end_time = $data['recurrence']['end_date_time'];

        $zoom = new ZoomService(
            $data['meeting']['topic'], 
            $start_time, 
            60,
            null,
            $data['meeting']['password'],
        );

        $response = $zoom->meeting(
            [
                'join_before_host' => true,
                'host_video' => true,
                'participant_video' => false,
                'mute_upon_entry' => true,
                'waiting_room' => config('zoom.waiting_room'),
                'approval_type' => config('zoom.approval_type'),
                'audio' => config('zoom.audio'),
                'auto_recording' => config('zoom.auto_recording'),
            ],
            [
                'type' => 2,
                'end_date_time' => $end_time,
                'weekly_days' => null,
            ]
            )
            ->create();

        return $response;
    }

    public function updateMeeting($data, $id = null)
    {
        if (!$id) {
            return $this->createMeeting($data);
        }
        $meeting = Zoom::meeting()->find($id);
        $meeting->update($data['meeting']);
        $meeting->settings()->update($data['setting']);
        return $meeting->save();
    }
}
