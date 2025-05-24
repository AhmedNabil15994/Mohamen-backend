<?php

namespace Modules\Reservation\Http\Controllers\Api;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Reservation\Http\Requests\Api\ReservationRequest;
use Modules\Reservation\Repositories\Api\ReservationRepository;
use Modules\Reservation\Transformers\Api\ReservationResource;
use Modules\Transaction\Services\UPaymentService;

class ReservationController extends ApiController {

  public function __construct(
    public ReservationRepository $reservationRepository,
    public UPaymentService $payment
  ) {
  }

  public function show($id) {
    return $this->response(new ReservationResource($this->reservationRepository->findById($id)));
  }

  public function reserve(ReservationRequest $request) {

    $reservation = $this->reservationRepository->reserve($request->validated());
    if ($reservation && 'cash' !== $reservation->payment_method) {
      return $this->response(['paymentUrls' => $this->payment->send($reservation, 'reservation')]);
    } elseif ($reservation && 'cash' == $reservation->payment_method) {
      return $this->response(result: new ReservationResource($reservation));
    }
    return $this->error($reservation[1], [], 400);
  }
}
