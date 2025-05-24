<?php

namespace Modules\Reservation\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Lawyer\Transformers\Api\LawyerResource;
use Modules\Reservation\Traits\ReservationTrait;
use Modules\Service\Transformers\Api\ServiceResource;
use Modules\User\Transformers\Api\UserResource;

class ReservationResource extends JsonResource {
  use ReservationTrait;
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request) {
    $zak = null;

    if (!is_null($response = $this->meeting?->zoom_response)) {
      if (!is_null($start_url = $response->start_url)) {
        $exp = explode("zak=", $start_url);
        $zak = $exp[1];
      }
    }

    $data = [
      'id'             => $this->id,
      'times'          => ReservationTimesResource::collection($this->times),
      'price'          => $this->total,
      'date'           => $this->date,
      'payment_method' => $this->payment_method,
      'meeting_start'  => $this->checkMeetingStart($this->date, $this->times),
      //   'meeting_start'  => true,
      'meeting'        => $this->meeting?->zoom_response,
      'zak'            => $zak,
      'service'        => new ServiceResource($this->service),
      'lawyer'         => new LawyerResource($this->lawyer),
      'user'           => new UserResource($this->user),
      'paid'           => __('reservation::dashboard.reservations.datatable.paid')[$this->paid],
    ];

    //\File::append(storage_path().'/logs/reservation-'.date('Y-m-d').'.log', json_encode($data));

    return $data;
  }
}
