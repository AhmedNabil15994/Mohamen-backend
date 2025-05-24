<?php

namespace Modules\Reservation\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationTimesResource extends JsonResource
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
            'from'   => $this['from'],
            'to'     => $this['to'],
        ];
    }
}
