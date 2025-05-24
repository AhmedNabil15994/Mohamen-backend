<?php

namespace Modules\Reservation\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\WorkingWithTimeTrait;
use Modules\Reservation\Entities\Reservation;
use Modules\Lawyer\Repositories\Api\LawyerRepository;
use Modules\Reservation\Http\Requests\Dashboard\ReservationCalendarRequest;
use Modules\Reservation\Transformers\Dashboard\ReservationCalendarResource;
use Modules\Reservation\Transformers\Dashboard\UnAvailablyCalendarResource;
use Modules\Reservation\Repositories\Dashboard\ReservationCalendarRepository;

class ReservationCalendarController extends Controller
{

    use WorkingWithTimeTrait;
    public $lawyerRepository;
    public $reservationCalendarRepository;

    public function __construct(LawyerRepository $lawyerRepository, ReservationCalendarRepository $reservationCalendarRepository)
    {
        $this->lawyerRepository = $lawyerRepository;
        $this->reservationCalendarRepository = $reservationCalendarRepository;
    }
    public function index()
    {
        $lawyers = $this->lawyerRepository->getAll();
        return view('reservation::dashboard.reservations-calendar.index', compact('lawyers'));
    }

    public function byDate(Request $request)
    {

        $reservations = Reservation::where('lawyer_id', $request->lawyer_id)->whereBetween(
            "date",
            [
                $request->start,
                $request->end
            ]
        )->get();
        $data    = ReservationCalendarResource::collection($reservations);
        $blocked = UnAvailablyCalendarResource::collection($this->handelBlockedTimes($request));
        return response()->json($blocked->merge($data));
    }


    public function store(ReservationCalendarRequest $request)
    {
        $reservation = $this->reservationCalendarRepository->create($request->validated());
        if ($reservation) {
            return Response()->json([true, __('apps::dashboard.messages.created')]);
        }
        return Response()->json([false, __('apps::dashboard.messages.failed')]);
    }

    private function   handelBlockedTimes($request)
    {
        $allTimes = [];
        $period = CarbonPeriod::create(
            Carbon::parse($request->start)->format('Y-m-d'),
            Carbon::parse($request->end)->format('Y-m-d')
        );
        foreach ($period as $date) {
            $availability =
                $this->lawyerRepository->findLawyerAvailabilitiesByDate(
                    $request->lawyer_id,
                    $date->format('Y-m-d')
                );
            $time = $this->unavailableTimes($availability, $date->format('Y-m-d'))->toArray();
            array_push($allTimes, ...$time);
        }
        return $allTimes;
    }

    public function delete(Request $request)
    {
        $reservation =   Reservation::where('id', $request->id)->delete();


        if ($reservation) {
            return Response()->json([true, __('apps::dashboard.messages.deleted')]);
        }
        return Response()->json([false, __('apps::dashboard.messages.failed')]);
    }
}
