<?php

namespace Modules\Reservation\Repositories\Api;

use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Api\ApiCrudRepository;
use Modules\Core\Traits\WorkingWithTimeTrait;
use Modules\Coupon\Entities\Coupon;
use Modules\Notification\Traits\SendNotificationTrait;
use Modules\Reservation\Entities\Reservation;
use Modules\Service\Entities\LawyerService;
use Modules\User\Entities\User;

class ReservationRepository extends ApiCrudRepository {
  use SendNotificationTrait;
  use WorkingWithTimeTrait;
  public function __construct() {
    parent::__construct(Reservation::class);
  }
  /**
   * @return mixed|null
   */
  public function getModel() {
    return $this->model->where('payment_method', '!=', 'calendar')
      ->where('paid', 'paid')
      ->with(['lawyer', 'user'])
      ->filterDateTime();
  }

  public function findById($id) {
    return $this->getModel()
      ->where(['user_id' => auth()->id()])
      ->orWhere(['lawyer_id' => auth()->id()])->find($id);
  }

  public function reserve($request) {
    try {
      DB::beginTransaction();
      $reservation = $this->create($request);
      DB::commit();
      return $reservation;
    } catch (\Exception $e) {
      throw $e;
    }
  }

  private function create($data) {
    $lawyerService =
    LawyerService::with('service')->where(['lawyer_id' => $data['lawyer_id'], 'service_id' => $data['service_id']])->first();
    $data['subtotal'] = $lawyerService->price * count($data['times']);
    $data['total']    = $lawyerService->price * count($data['times']);
    $reservation      = auth()->user()->reservations()->create($data);

    $reservation->times()->createMany($data['times']);
    if (request()->code && $coupon = Coupon::validCoupon(request()->code)->first()) {
      $this->handelCoupon($reservation, $coupon);
    }

    return $reservation->load('times');
  }

  public function toggleJoinNotification($joinRequest) {
    $joinMessageData = [
      'ar' =>
      ['title' => 'طلب مشاركه ', 'body' => 'هناك طلب مشاركه جديد ', 'type' => 'join_request', 'id' => null],
      'en' => ['title' => 'Join Request', 'body' => 'New Join Request', 'type' => 'join_request', 'id' => null],
    ];
    $notData = [
      'title' => [
        'ar' => $joinMessageData['ar']['title'],
        'en' => $joinMessageData['en']['title'],
      ],
      'body'  => [
        'ar' => $joinMessageData['ar']['body'],
        'en' => $joinMessageData['en']['body'],
      ],
    ];

    $user = User::with('fcmTokens')->whereHas('reservations', fn($q) => $q->where('id', $joinRequest->reservation_id))->first();

    $user->notifications()->create($notData);
    $this->sendTranslatedMessageToUser($joinMessageData, $user->fcmTokens);
  }

  public function handelCoupon(&$reservation, $coupon) {
    $subtotal = $reservation->subtotal;
    $reservation->update([
      'total' => ($reservation->subtotal - $coupon->applyCoupon($subtotal)),
    ]);
    $reservation->coupons()->create([
      'code'                => $coupon->code,
      'discount_type'       => $coupon->is_fixed ? 'value' : 'percentage',
      'discount_percentage' => $subtotal > 0 ? (1 - ($reservation->total / $subtotal)) * 100 : null,
      'discount_value'      => $subtotal - $reservation->total,
      'coupon_id'           => $coupon->id,
    ]);

    return $reservation;
  }

  public function notifyUsers($reservation) {
    $date  = $reservation->date;
    $times = $reservation->times;
    foreach ($times as $time) {
      $fullDate = strtotime($date . ' ' . $time->from);
      $diff     = (abs(time() - $fullDate) / 60 / 60);
      if (1 == $diff) {
        $joinMessageData = [
          'ar' => ['title' => 'ميعاد استشارة قادم', 'body' => 'هناك معياد استشاره في خلال ساعة ', 'type' => 'reserve_notify', 'id' => $reservation->id],
          'en' => ['title' => 'Upcoming Consultation Appointment', 'body' => 'There will be a consultation within an hour', 'type' => 'reserve_notify', 'id' => $reservation->id],
        ];
        $notData = [
          'title' => [
            'ar' => $joinMessageData['ar']['title'],
            'en' => $joinMessageData['en']['title'],
          ],
          'body'  => [
            'ar' => $joinMessageData['ar']['body'],
            'en' => $joinMessageData['en']['body'],
          ],
        ];

        $user = User::with('fcmTokens')->whereHas('reservations', fn($q) => $q->where('id', $reservation->id))->first();
        $user->notifications()->create($notData);
        $this->sendTranslatedMessageToUser($joinMessageData, $user->fcmTokens);
      }
    }
  }
}
