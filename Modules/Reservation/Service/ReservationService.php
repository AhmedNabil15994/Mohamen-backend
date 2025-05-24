<?php

namespace Modules\Reservation\Service;

use Carbon\Carbon;
use Modules\Reservation\Entities\Reservation;
use Modules\Reservation\Traits\MeetingZoomTrait;

class ReservationService
{
    use MeetingZoomTrait;

    public function handelReservationMeeting(Reservation $reservation)
    {
        $newMeeting = $this->handelDataForMeeting($reservation);
        $meeting = $this->createMeeting($newMeeting);

        // $reservation->meeting()->create(['zoom_meeting_id' => $meeting->id, 'zoom_response' => $meeting->getAttributes()]);
        $reservation->meeting()->create(['zoom_meeting_id' => $meeting->id, 'zoom_response' => $meeting]);
    }
    public function updateReservationMeeting(Reservation $reservation)
    {
        $newMeeting = $this->handelDataForMeeting($reservation);
        $meeting = $this->updateMeeting($newMeeting, data_get($reservation, 'meeting->zoom_response->id', null));
        $reservation->meeting()->updateOrCreate(
            ['meetingable_id' => $reservation->id,
                'meetingable_type' => 'Modules\Reservation\Entities\Reservation'],
            [
                'zoom_meeting_id' => $meeting->id,
                'zoom_response' => $meeting->getAttributes(),
            ]
        );
    }

    public function handelDataForMeeting($reservation)
    {
        $data = [];
        $reservationTime = Carbon::parse($reservation->first_time);
        $startTime = $reservationTime->format('Y-m-d H:i:s');
        $endTime = $reservationTime->addHour($reservation->times()->count())->format('Y-m-d H:i:s');
        $title = $reservation->lawyer->name . ' - ' . $reservation->service->title;
        $duration = round(abs(strtotime($startTime) - strtotime($endTime)) / 60, 2); // in minutes

        $data['meeting'] = [
            'topic' => $title,
            'start_time' => $this->zoomFormat($startTime),
            'duration' => $duration,
            'password' => "12345678",
        ];
        $data['recurrence'] = [
            'type' => 2,
            'end_date_time' => $this->zoomFormat($endTime),
            'weekly_days' => null,
        ];
        $data['setting'] = [
            'join_before_host' => true,
            'host_video' => true,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => config('zoom.waiting_room'),
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording'),
            // 'contact_email' => request()->user()->name ?? '',
            // 'contact_name' => request()->user()->email ?? '',
        ];

        return $data;
    }

    public function zoomFormat($time)
    {
        return Carbon::parse($time)->format('Y-m-d h:i:s A');
    }
}
