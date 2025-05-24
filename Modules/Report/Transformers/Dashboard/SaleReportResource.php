<?php

namespace Modules\Report\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleReportResource extends JsonResource
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
            'id'         => $this->id,
            'name'       => $this->name,
            'user'       => $this->name,
            'totalPrice' => $this->totalPrice,
            'totalCount' => $this->totalCount,
        ];
    }
}
