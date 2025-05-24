<?php

namespace Modules\Reservation\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $first_record = $this->times()->first();
        $times = '--';
        
        if( !is_null($first_record) )
        {
            $times = $first_record->from .' <br /> '.$first_record->to;
        }

        $paid = __('reservation::dashboard.reservations.datatable.paid')[$this->paid];
        if( in_array($this->payment_method, ['calendar', 'dashboard']) )
        {
            $paid .= "<br /><small class=text-info>".__('reservation::dashboard.reservations.datatable.paid_by_admin')."</small>";
        }

        return [
            'id'         => $this->id,
            'service'    => $this->service->title,
            'lawyer'     => $this->lawyer->name,
            'reservation_date'     => \Carbon\Carbon::parse($this->first_time)->format('Y-m-d'),
            'times'     => $times,
            'user'       => $this->user?->name ?? $this->name,
            'paid'       => $paid,
        ];
    }
}
