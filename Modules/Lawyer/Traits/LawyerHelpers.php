<?php

namespace Modules\Lawyer\Traits;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait LawyerHelpers {

  public function getAllDatesBetweenTwoDates($dateFrom, $dateTo) {
    $dates  = [];
    $period = \Carbon\CarbonPeriod::create($dateFrom, $dateTo);
    foreach ($period as $date) {
      $dates[] = $date->format('Y-m-d');
    }
    return $dates;
  }
  public function extractRestaurantVacationsRange($customVacations) {
    $customVacationsData = [];
    if (!empty($customVacations)) {
      foreach ($customVacations as $i => $vacation) {
        $customVacationsData[] = $this->getAllDatesBetweenTwoDates($vacation['date_from'], $vacation['date_to']);
      }
      $customVacationsData = Arr::collapse($customVacationsData);
    }
    return $customVacationsData;
  }

  public function isClosedOn($date) {

    $vacations       = $this->vacation->weekly_vacations ?? [];
    $currentDate     = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime(date('Y-m-d'))));
    $date            = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($date)));
    $shortDay        = Str::lower($date->format('D'));
    $customVacations = array_unique($this->extractRestaurantVacationsRange($this->vacation ? $this->vacation->date_ranges : []) ?? []);

    $isClosed = false;
    if (in_array($shortDay, $vacations ?? [])) {
      $isClosed = true;
    }

    if (!empty($customVacations) && in_array($date->format('Y-m-d'), $customVacations)) {
      $isClosed = true;
    }

    if ($date < $currentDate) {
      $isClosed = true;
    }

    return $isClosed;
  }
}
