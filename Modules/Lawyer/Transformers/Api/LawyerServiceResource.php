<?php

namespace Modules\Lawyer\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\Api\CategoryResource;

class LawyerServiceResource extends JsonResource
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
            'id'        => $this->id,
            "title"     => $this->title,
            "type"     => $this->type,
            "desc"      => $this->desc,
            'image'      => $this->getFirstMediaUrl('images'),
            "price"      => $this->pivot->price,
        ];
    }
}
