<?php

namespace Modules\Blog\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'id'                 => $this->id,
            'title'              => $this->title,
            'desc'               => $this->desc,
            'image'              => $this->getFirstMediaUrl('images'),
            'created_at'         => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
