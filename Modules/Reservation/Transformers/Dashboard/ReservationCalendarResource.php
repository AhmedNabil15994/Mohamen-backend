<?php


namespace Modules\Reservation\Transformers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            "id"             => $this->id,
            "title"          => $this->user?->name ?? $this->name,
            "isAllday"       => false,
            "extendedProps" => [
                "deletable" => true,
                "creator" =>
                [
                    "name" => $this->user?->name ?? $this->name,
                    "lawyer" => $this->lawyer?->name,
                    "service" => $this->service->title,
                    "image" => $this->user?->getFirstMediaUrl('images'),
                    "email" => $this->user?->email,
                    "phone" => $this->user?->mobile_code . $this->user?->mobile
                ],
            ]

        ];

        return array_merge($data, $this->handelRange($this));
    }




    public function handelAttendees($players)
    {
        return $players->pluck('user.name')->toArray();
    }
    public function handelRange($reservation)
    {
        return  [
            "start" => $reservation->first_time,
            "end"   => Carbon::parse($reservation->first_time)->addMinutes(60 * count($reservation->times))
        ];
    }
}
