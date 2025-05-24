<?php

namespace Modules\Lawyer\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Entities\City;
use Modules\Area\Transformers\Api\CityResource;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\Api\CategoryResource;

class LawyerProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "about" => $this->about,
            "job_title" => $this->job_title,
            "online" => $this->status,
            "city" => new CityResource($this->city),
        ];
    }
}
