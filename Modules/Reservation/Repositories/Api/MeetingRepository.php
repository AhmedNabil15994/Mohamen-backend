<?php

namespace Modules\Reservation\Repositories\Api;

use Carbon\Carbon;
use Modules\Core\Repositories\Api\ApiCrudRepository;
use Modules\Reservation\Entities\Reservation;
// use Modules\Reservation\Traits\MeetingZoomTrait;
use Offlineagency\LaravelWebex\LaravelWebex;

class MeetingRepository extends ApiCrudRepository
{
    // use MeetingZoomTrait;

    public $laravelWebex;
    public function __construct()
    {
        parent::__construct(Reservation::class);
        $this->laravelWebex = new LaravelWebex(config('webex.bearer'));
    }

    public function handelMeeting($reservation)
    {
        $meeting = $this->createMeeting($reservation);
        if (empty($meeting->errors)) {
            $reservation->meeting()
                ->create([
                    'zoom_meeting_id' => $meeting->id,
                    'zoom_response' => $meeting,
                ]);
        }else{
            return false;
        }

    }

    public function createMeeting($reservation)
    {
        $reservationTime = Carbon::parse($reservation->first_time);
        $startTime = $reservationTime->format('Y-m-d H:i:s');
        $endTime = $reservationTime->addHour($reservation->times()->count())->format('Y-m-d H:i:s');
        $title = $reservation->lawyer->name . ' - ' . $reservation->service->title;
        $newMeeting = $this->laravelWebex->meeting()
            ->create($title, $startTime, $endTime, [
                'agenda' => 'Meeting',
                'enabledAutoRecordMeeting' => false,
            ]);
        return $newMeeting;
    }
}
