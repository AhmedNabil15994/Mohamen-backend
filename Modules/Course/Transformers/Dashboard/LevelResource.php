<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
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
        'id' => $this->id,
        'title' => $this->title,
        'short_desc' => $this->short_desc,
        'deleted_at' => $this->deleted_at,
        'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
