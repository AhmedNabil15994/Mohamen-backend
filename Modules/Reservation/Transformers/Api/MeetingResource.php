<?php

namespace Modules\Reservation\Transformers\Api;

use Modules\Area\Transformers\Api\CityResource;
use Modules\Club\Transformers\Api\ClubResource;
use Modules\User\Transformers\Api\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Transformers\Api\StateResource;
use Modules\Lawyer\Transformers\Api\LawyerResource;
use Modules\Service\Transformers\Api\ServiceResource;

class MeetingResource extends JsonResource
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
            
        ];
    }
}
