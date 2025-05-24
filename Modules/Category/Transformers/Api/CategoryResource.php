<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\Api\CompanyResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'image'         => $this->getFirstMediaUrl('images'),

        ];
    }
}
