<?php

namespace Modules\Reservation\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Service\Entities\LawyerService;
use Modules\Core\Traits\WorkingWithTimeTrait;
use Modules\Reservation\Entities\Reservation;
use Modules\Club\Repositories\Api\ClubRepository;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ReservationCalendarRepository
{
    use WorkingWithTimeTrait;
    public function create($data)
    {
        $lawyerService = LawyerService::where(['lawyer_id' => $data['lawyer_id'], 'service_id' => $data['service_id']])->first();
        $data['subtotal'] = $lawyerService->price  * count($data['times']);
        $data['total'] = $lawyerService->price * count($data['times']);
        //paid by default
        $data['paid'] = 'paid';
        $reservation = Reservation::create($data);
        $reservation->times()->createMany($data['times']);
        return $reservation->load('times');
    }
}
