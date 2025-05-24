<?php

namespace Modules\Reservation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Reservation\Entities\Reservation;
use Modules\Reservation\Events\PaidEvent;
use Modules\Reservation\Repositories\Api\MeetingRepository;
use Modules\Reservation\Repositories\Api\ReservationRepository;
use Modules\Reservation\Service\ReservationService;

class AfterPaidController extends ApiController {
  public function __construct(
    public ReservationRepository $reservationRepository,
    public Reservation $model,
    public MeetingRepository $meetingRepository,
    public ReservationService $reservationService
  ) {
  }
  public function success(Request $request) {
    $model = $this->updatePaidStatus($request);
    if ($model) {
      event(new PaidEvent($model));
      return $this->response([], message: __('apps::api.messages.success'));
    }
    return $this->error(__('apps::api.messages.failed'));
  }
  public function failed(Request $request) {
    $model = $this->updatePaidStatus($request);
    return $this->error(__('apps::api.messages.failed'));
  }
  public function updatePaidStatus($request) {
    $model = $this->model->where('paid', 'pending')->find($request['OrderID']);
    DB::beginTransaction();
    try {
      if ($model) {
        $status['paid'] = 'failed';
        if ('CAPTURED' == $request['Result']) {
          $status['paid'] = 'paid';
          $this->reservationService->handelReservationMeeting($model);
          // $this->meetingRepository->handelMeeting($model);
        }
        $model->update($status);
        $model->transactions()->updateOrCreate([
          'payment_id' => $request->PaymentID,
        ], [
          'method'     => 'knet',
          'payment_id' => $request->PaymentID,
          'tran_id'    => $request->TranID,
          'result'     => $request->Result,
          'post_date'  => $request->PostDate,
          'ref'        => $request->Ref,
          'track_id'   => $request->TrackID,
          'auth'       => $request->Auth,
        ]);
        if ('failed' == $model->paid || 'failed' == $model->status) {
          $model->delete();
        }
        DB::commit();
        return true;
      }
      return false;
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
  }
}
