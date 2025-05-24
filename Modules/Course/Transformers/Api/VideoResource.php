<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'video_link'    => $this->video_link,
            'video_length'  => $this->video_length,
            'thumb'         => $this->thumb,
        ];

        return $columns;
    }
}
