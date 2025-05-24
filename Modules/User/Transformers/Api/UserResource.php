<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\Api\CompanyResource;
use Modules\Level\Transformers\Api\LevelResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'email'              => $this->email,
            'image'              => $this->getFirstMediaUrl('images'),
            'mobile'             => $this->mobile_code . '' . $this->mobile,
            'matches_count'      => $this->joined_reservations_count,
            'won_count'          => $this->wining_joined_reservations_count,
            'level'              => new LevelResource($this->level),
            'uid'                => $this->uid,
        ];
    }
}
