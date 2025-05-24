<?php

namespace Modules\User\Repositories\Api;

use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Reservation\Entities\Reservation;
use Modules\Reservation\Repositories\Api\ReservationRepository;
use Modules\User\Entities\User;

class UserRepository {
  public function __construct(User $user, ReservationRepository $reservations) {
    $this->user         = $user;
    $this->reservations = $reservations;
  }

  public function getAll() {
    return $this->user->doesntHave('company')->orderBy('id', 'DESC')->get();
  }

  public function update($data) {

    DB::beginTransaction();

    try {
      $user  = Auth::user();
      $image = Arr::pull($data, 'image');
      if ($image) {
        $user->clearMediaCollection('images');
        $user->addMedia($image)->toMediaCollection('images');
      }
      $user->update($data);

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL            => 'https://' . config('services.cometchat.app_id') . '.api-in.cometchat.io/v3/users/' . $user->uid,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'PUT',
        CURLOPT_POSTFIELDS     => array('uid' => $user->uid, 'name' => $user->name ?? 'user-' . $user->id, 'email' => $user->email ?? '', 'contactNumber' => $user->mobile ?? '', 'avatar' => $user->getFirstMediaUrl('images') == '' ? 'https://app.mohamen.net/' : $user->getFirstMediaUrl('images')),
        CURLOPT_HTTPHEADER     => array(
          'apikey: ' . config('services.cometchat.apikey'),
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
  }

  public function userProfile() {
    return $this->user->where('id', auth()->id())->first();
  }
  public function userReservations($request) {

    $filterDate = [
      'pending' => ['first_time', '<=', now()->toDateTimeString()],
      'pending' => ['finish_time', '>=', now()->toDateTimeString()],
      'past'    => ['finish_time', '<', now()->toDateTimeString()],
    ];

    return $this->reservations->getModel()->where(function ($query) {
      return $query
        ->where('user_id', auth('sanctum')->id())
        ->orWhere('lawyer_id', auth('sanctum')->id());
    })->when($request->date, fn($q, $val) => $q->where([data_get($filterDate, $request->date)]))
      ->orderBy('id', 'desc')
      ->paginate($request->pageCount ?? 10);

    // return $this->reservations->getModel()->where(function ($query) {
    //   return $query
    //     ->where('user_id', auth('sanctum')->id())
    //     ->orWhere('lawyer_id', auth('sanctum')->id());
    // })->when($request->date, function ($query) use ($request) {
    //   if ('pending' == $request->date) {
    //     return $query->where('first_time', '<=', now()->toDateTimeString())
    //       ->where('finish_time', '>=', now()->toDateTimeString());
    //   } else {
    //     return $query->where('finish_time', '<', now()->toDateTimeString());
    //   }
    // })
    //   ->orderBy('id', 'desc')
    //   ->paginate($request->pageCount ?? 10);
  }

  public function upcomingReservations() {
    $data = Reservation::with('meeting')
      ->where('user_id', auth()->user()->id)
      ->wherePaid('paid')
      ->whereDate('first_time', '>=', today())
      ->first();

    if (is_null($data)) {return null;}

    $zak = null;

    if (!is_null($response = $data->meeting?->zoom_response)) {
      if (!is_null($start_url = $response->start_url)) {
        $exp = explode("zak=", $start_url);
        $zak = $exp[1];
      }
    }

    return collect(array_merge($data->toArray(), ['zak' => $zak]));
  }

  public function findById($id) {
    return $this->user->where('id', $id)->first();
  }
  public function userNotifications($request) {

    $filterDate = [
      'pending' => ['first_time', '<=', now()->toDateTimeString()],
      'pending' => ['finish_time', '>=', now()->toDateTimeString()],
      'done'    => ['finish_time', '<', now()->toDateTimeString()],
    ];

    return $this->reservations->getModel()->where(function ($query) {
      return $query
        ->where('user_id', auth('sanctum')->id())
        ->orWhere('lawyer_id', auth('sanctum')->id());
    })->where(function ($q) use ($request, $filterDate) {
      if ($request->status) {
        $q->where([data_get($filterDate, $request->status)]);
      }
    })->paginate($request->pageCount ?? 10);
  }

}
