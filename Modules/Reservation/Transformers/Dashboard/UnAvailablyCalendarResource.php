<?php


namespace Modules\Reservation\Transformers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UnAvailablyCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "title"            => '',
            'backgroundColor'  => '#cccc',
            'textColor'        => '#ccc',
            'borderColor'      => '#ccc',
            'overlap'          => false,
            'allDay' => false,
            'displayEventTime' => true,
            "extendedProps" => [
                "deletable" => false,
            ],
            "start"            => Carbon::parse($this['from']),
            "end"              => Carbon::parse($this['to'])
        ];
    }
}
