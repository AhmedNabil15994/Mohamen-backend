<?php

namespace Modules\Reservation\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Reservation\Rules\ReservationTimeAfterNow;
use Modules\Reservation\Rules\ReservationTimeExist;

class ReservationRequest extends FormRequest {
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      'lawyer_id'      => 'required|exists:users,id',
      'service_id'     => 'required|exists:services,id',
      'date'           => 'required|date|after:yesterday',
      'times.*'        => ['required', new ReservationTimeExist()],
      'times.*.from'   => ['required', new ReservationTimeAfterNow()],
      'times.*.to'     => 'required',
      'payment_method' => 'required|in:knet',
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }

  public function validated() {
    $data               = $this->validator->validated();
    $data['first_time'] = Carbon::parse(
      $data['date'] . ' ' . $data['times'][0]['from']
    );
    $data['finish_time'] = Carbon::parse(
      $data['date'] . ' ' . $data['times'][0]['to']
    );

    return $data;
  }
}
