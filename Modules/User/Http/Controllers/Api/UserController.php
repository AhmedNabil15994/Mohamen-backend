<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Reservation\Transformers\Api\ReservationNotificationResource;
use Modules\Reservation\Transformers\Api\ReservationResource;
use Modules\User\Http\Requests\Api\UpdateProfileRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\User\Transformers\Api\UserResource;

class UserController extends ApiController {
  public $user;
  public function __construct(User $user) {
    $this->user = $user;
  }

  public function profile() {
    $user = $this->user->userProfile();
    return $this->response(new UserResource($user));
  }

  public function generateUid() {
    $user = auth()->user();
    if (!$user->uid) {
      $uid = $user->mobile . '_' . time();
      $user->update(['uid' => $uid]);
      $user->refresh();
    }
    //get user from commet chat
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL            => 'https://' . config('services.cometchat.app_id') . '.api-in.cometchat.io/v3/users/' . $user->uid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING       => '',
      CURLOPT_MAXREDIRS      => 10,
      CURLOPT_TIMEOUT        => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST  => 'GET',
      CURLOPT_HTTPHEADER     => array(
        'apikey: ' . config('services.cometchat.apikey'),
      ),
    ));
    $response = json_decode(curl_exec($curl));
    curl_close($curl);
    if (isset($response->error)) {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL            => 'https://' . config('services.cometchat.app_id') . '.api-in.cometchat.io/v3/users',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => array('uid' => $user->uid, 'name' => $user->name ?? 'user-' . $user->id, 'email' => $user->email ?? '', 'contactNumber' => $user->mobile ?? '', 'avatar' => $user->getFirstMediaUrl('images') == '' ? 'https://app.mohamen.net/' : $user->getFirstMediaUrl('images')),
        CURLOPT_HTTPHEADER     => array(
          'apikey: ' . config('services.cometchat.apikey'),
        ),
      ));
      $response = curl_exec($curl);
    }
    return $this->response(new UserResource($user));
  }

  public function updateProfile(UpdateProfileRequest $request) {

    $this->user->update($request->validated());

    $user = $this->user->userProfile();

    return $this->response(new UserResource($user));
  }

  public function myReservations(Request $request) {
    return ReservationResource::collection($this->user->userReservations($request));
  }

  public function upcomingReservations(Request $request) {
    return $this->response($this->user->upcomingReservations());
    // return ReservationResource::collection($this->user->upcomingReservations());
  }

  public function myNotifications(Request $request) {
    return ReservationNotificationResource::collection($this->user->userNotifications($request));
  }
}
