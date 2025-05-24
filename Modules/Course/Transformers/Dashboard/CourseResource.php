<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Dashboard\CategoryResource;

class CourseResource extends JsonResource
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
            'id'           => $this->id,
            'title'        => $this->title,
            'video_status' => $this->video?->video_status,
            'deleted_at'   => $this->deleted_at,
            'created_at'   => date('d-m-Y', strtotime($this->created_at)),
            'category'   => $this->category?->title ?? '',
        ];
    }
}
