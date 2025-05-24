<?php

namespace Modules\Level\Transformers\Dashboard;

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
                 'id'                 => $this->id,
                 'title'              => $this->title,
                 'winning_count'      => $this->winning_count,
                 'created_at'         => date('d-m-Y', strtotime($this->created_at)),
              ];
    }
}
