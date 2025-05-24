<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Transformers\Api\VideoResource;
use Modules\Course\Transformers\Api\LessonResource;
use Modules\Category\Transformers\Api\CategoryResource;
use Modules\User\Transformers\Api\UserResource;

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
            'id'            => $this->id,
            'title'         => $this->title,
            'desc'          => $this->desc,
            'target'        => $this->desc,
            'period'        => $this->period,
            'instructor'    => new UserResource($this->instructor),
            'is_subscribed' => $this->isSubscribed,
            'price'         => $this->price,
            'video'         => $this->when($this->video, new VideoResource($this->video)),
            'lessons'       => LessonResource::collection($this->lessons),
            'categories'    => CategoryResource::collection($this->categories),
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
