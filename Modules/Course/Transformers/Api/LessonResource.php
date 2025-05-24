<?php

namespace Modules\Course\Transformers\Api;

use Modules\Course\Entities\LessonContent;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Transformers\Api\LessonContentResource;

class LessonResource extends JsonResource
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
            'title'         => $this->title,
            'video'         => $this->when($this->video, new VideoResource($this->video)),
            'status'        => $this->status,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
