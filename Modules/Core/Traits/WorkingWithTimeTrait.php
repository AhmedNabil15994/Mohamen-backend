<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Reservation\Entities\ReservationTime;

trait WorkingWithTimeTrait {
  public function availableTimes($availability, $date) {
    $times = $this->getTimes($availability);

    $times = $times->map(function ($times) {
      $is_available = true;
      if (!is_null($user = auth()->user())) {
        $is_available = $user->reservations()->whereHas('times', function ($q) use ($times) {
          return $q->where('from', $times['from']);
        }) ? false : true;
      }

      return array_merge($times, ['is_available' => $is_available]);
    });
    $afterExclude = $this->excludeReceivedTimes($availability->available_id, $date, $times);
    return $afterExclude;
  }

  public function unavailableTimes($availability, $date) {
    $times = $availability ? $this->getTimes($availability) : [];
    if ([] == $times) {
      return collect(
        [["from" => "$date 12:00 AM", "to" => "$date 11:59:59 PM"]]
      );
    }
    $afterExclude = $this->excludeTimesFromDayTimes($times, $date);
    return $afterExclude;
  }

  private function excludeTimesFromDayTimes(Collection $times, $date) {

    $remainingTimes = collect();
    for ($i = 0; $i <= 23; $i++) {
      $from = Carbon::parse("$i:00:00")->format('h:i A');
      $to   = Carbon::parse("$i:00:00")->addHours(1)->format('h:i A');
      $time = $times->where('from', $from)->first();
      if (!$time) {
        $remainingTimes->push(['from' => $date . ' ' . $from, 'to' => $date . ' ' . $to]);
      }
    }
    return $remainingTimes;
  }
  private function formateTimeToDate($time) {
    return Carbon::make(Carbon::parse($time)->format('Y-m-d h:i A'));
  }
  private function generateDateRange(Carbon $start_date, Carbon $end_date) {
    $dates = collect();
    for ($date = $start_date->copy(); $date->lt($end_date);) {
      $newDate['from'] = $date->format('h:i A');
      $newDate['to']   = $date->addHour()->format('h:i A');
      $dates->push($newDate);
    }
    return $dates;
  }
  private function getTimes($availability) {

    $times = collect();
    if ($availability?->is_full_day != 1) {
      foreach ($availability?->custom_times ?? [] as $time) {
        $range = $this->generateDateRange(
          $this->formateTimeToDate($time['time_from']),
          $this->formateTimeToDate($time['time_to']),
        );
        $times->push(...$range);
      }
      return $times;
    } else {
      return $this->getFullDayRange();
    }
  }

  private function excludeReceivedTimes($lawyer_id, $date, $times) {
    $minutes = now()->diffInMinutes(now()->endOfHour());

    if (today() == \Carbon\Carbon::parse($date)) {
      $times = $times->filter(function ($value, $key) use ($minutes) {
        if (isset($value['from'])) {
          $from = strtotime($value['from']);

          // return $from > now()->addMinutes($minutes)->timestamp;
          return $from > now()->addHour()->timestamp;
        }

        return true;
      });
    }

    $reservedTimes = ReservationTime::whereHas(
      'reservation',
      fn($q) => $q->where('paid', '!=', 'failed')->lawyerAndDate($lawyer_id, $date)
    )->get();

    return $times
      ->whereNotIn('from', $reservedTimes->pluck('from'));

  }

  public function getFullDayRange() {
    return collect([
      [
        "from" => "12:00 AM",
        "to"   => "01:00 AM",
      ],
      [
        "from" => "01:00 AM",
        "to"   => "02:00 AM",
      ],
      [
        "from" => "02:00 AM",
        "to"   => "03:00 AM",
      ],
      [
        "from" => "03:00 AM",
        "to"   => "04:00 AM",
      ],
      [
        "from" => "04:00 AM",
        "to"   => "05:00 AM",
      ],
      [
        "from" => "05:00 AM",
        "to"   => "06:00 AM",
      ],
      [
        "from" => "06:00 AM",
        "to"   => "07:00 AM",
      ],
      [
        "from" => "07:00 AM",
        "to"   => "08:00 AM",
      ],
      [
        "from" => "08:00 AM",
        "to"   => "09:00 AM",
      ],
      [
        "from" => "09:00 AM",
        "to"   => "10:00 AM",
      ],
      [
        "from" => "10:00 AM",
        "to"   => "11:00 AM",
      ],
      [
        "from" => "11:00 AM",
        "to"   => "12:00 PM",
      ],
      [
        "from" => "12:00 PM",
        "to"   => "01:00 PM",
      ],
      [
        "from" => "01:00 PM",
        "to"   => "02:00 PM",
      ],
      [
        "from" => "02:00 PM",
        "to"   => "03:00 PM",
      ],
      [
        "from" => "03:00 PM",
        "to"   => "04:00 PM",
      ],
      [
        "from" => "04:00 PM",
        "to"   => "05:00 PM",
      ],
      [
        "from" => "05:00 PM",
        "to"   => "06:00 PM",
      ],
      [
        "from" => "06:00 PM",
        "to"   => "07:00 PM",
      ],
      [
        "from" => "07:00 PM",
        "to"   => "08:00 PM",
      ],
      [
        "from" => "08:00 PM",
        "to"   => "09:00 PM",
      ],
      [
        "from" => "09:00 PM",
        "to"   => "10:00 PM",
      ],
      [
        "from" => "10:00 PM",
        "to"   => "11:00 PM",
      ],
      [
        "from" => "11:00 PM",
        "to"   => "12:00 AM",
      ],
    ]);
  }
}
