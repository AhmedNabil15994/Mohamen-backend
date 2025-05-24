<?php

namespace Modules\Reservation\Traits;

use Carbon\Carbon;

trait ReservationTrait {
  public function checkMeetingStart($reservationDate, $times) {
    $from      = $times[0]['from'];
    $to        = $times[0]['to'];
    $startDate = Carbon::createFromFormat('Y-m-d H:i a', $reservationDate . ' ' . $from);
    $endDate   = Carbon::createFromFormat('Y-m-d H:i a', $reservationDate . ' ' . $to);
    return Carbon::now()->between($startDate, $endDate, true) == true;
  }
}
