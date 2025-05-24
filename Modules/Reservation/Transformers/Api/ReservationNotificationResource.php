<?php

namespace Modules\Reservation\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Lawyer\Transformers\Api\LawyerResource;
use Modules\Reservation\Traits\ReservationTrait;
use Modules\Service\Transformers\Api\ServiceResource;
use Modules\User\Transformers\Api\UserResource;

class ReservationNotificationResource extends JsonResource {
  use ReservationTrait;
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request) {
    return [
      'id'             => $this->id,
      'date'           => $this->date,
      'payment_method' => $this->payment_method,
      'meeting_start'  => $this->checkMeetingStart($this->date, $this->times),
      // 'meeting_start'  => true,
      // 'is_done'        => $this->date > date("Y-m-d") ? __('No') : __('Yes'),
      'is_done'        => $this->isDone($this->first_time),

      'meeting'        => $this->meeting?->zoom_response,
      'service'        => new ServiceResource($this->service),
      'lawyer'         => new LawyerResource($this->lawyer),
      'user'           => new UserResource($this->user),
    ];
  }

  public function isDone($time) {

    $test = \Carbon\Carbon::createFromTimeString($time);

    $start = \Carbon\Carbon::createFromTimeString(now()->toDateTimeString());
    $end   = \Carbon\Carbon::createFromTimeString(now()->toDateTimeString())->addHour();

    if ($test->between($start, $end)) {
      return __('No');
    }

    return __('Yes');
  }

}
