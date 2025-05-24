<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $columns = [
            'id'            => $this->id,
            'title'         => $this->title,
            'video_link'    => $this->video?->video_link,
        ];

        return $columns;
    }
}
