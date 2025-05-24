<?php

namespace Modules\Reservation\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\Api\UserResource;

class ReservationPlayerResource extends JsonResource
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
            'id'             => $this->id,
            'user'           => new UserResource($this->user),
            'won'            => $this->won
        ];
    }
}
