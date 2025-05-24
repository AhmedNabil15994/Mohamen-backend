<?php

namespace Modules\Reservation\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\Api\UserResource;

class JoinRequestResource extends JsonResource
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
            'reservation_id' => $this->reservation_id,
            'user_id'        => $this->user_id,
            'user'           => new UserResource($this->whenLoaded('user')),
            'status'         => $this->status,
        ];
    }
}
