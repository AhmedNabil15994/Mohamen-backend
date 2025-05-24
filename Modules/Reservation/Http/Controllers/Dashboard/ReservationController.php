<?php

namespace Modules\Reservation\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Lawyer\Entities\Lawyer;
use Modules\Service\Entities\LawyerService;
use Modules\User\Entities\User;

class ReservationController extends Controller {
  use CrudDashboardController;

  public function store(Request $request) {
    $lawyer  = Lawyer::findOrFail($request->lawyer_id);
    $user    = User::findOrFail($request->user_id);
    $service = LawyerService::where('lawyer_id', $lawyer->id)->where('service_id', $request->service_id)->firstOrFail();

    $fromto = explode("-", $request->time);

    $from = trim($fromto[0]);
    $to   = trim($fromto[1]);

    $reservation = $lawyer->reservations()->create(
      [
        'user_id'        => $user->id,
        'service_id'     => $request->service_id,
        'date'           => $request->date,
        'first_time'     => \Carbon\Carbon::parse($request->date . ' ' . $from)->format('Y-m-d H:i:s'),
        'paid'           => 'paid',
        'payment_method' => 'dashboard',
        'subtotal'       => $service->price,
        'total'          => $service->price,
      ]
    );

    $reservation->times()->create([
      'from' => $from,
      'to'   => $to,
    ]);

    return back()->with('success', 'تم إضافة الموعد بنجاح');
  }
}
