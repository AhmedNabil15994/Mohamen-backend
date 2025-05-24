<?php

namespace Modules\Lawyer\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\Api\CategoryResource;

class LawyerResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'image'         => $this->getFirstMediaUrl('images'),
            'categories'    => CategoryResource::collection($this->categories),
            'profile'       => new LawyerProfileResource($this->profile),
            'uid'           => $this->uid,
        ];
    }
}
