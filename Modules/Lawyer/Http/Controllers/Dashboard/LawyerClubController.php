<?php

namespace Modules\Lawyer\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Club\Entities\Club;

use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


use Modules\Core\Traits\DataTable;
use Modules\Reservation\Entities\Reservation;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Lawyer\Repositories\Dashboard\LawyerClubRepository;
use Modules\Reservation\Transformers\Dashboard\ReservationResource;

class LawyerClubController extends Controller
{
    public $lawyerClubRepository;
    public function __construct(LawyerClubRepository $lawyerClubRepository)
    {
        $this->lawyerClubRepository = $lawyerClubRepository;
        $this->middleware('permission:lawyer_access');
    }

    public function index()
    {
        $clubs = Club::whereLawyerId(auth()->id())->withCount('reservations')->get();
        return view('lawyer::dashboard.lawyers.dashboard.clubs', compact('clubs'));
    }



    public function reservations($clubId)
    {
        if (request()->ajax()) {
            $request = request();
            return $this->lawyerClubRepository->datatable($request, $clubId);
        }
        return view('lawyer::dashboard.lawyers.dashboard.reservations.index', compact('clubId'));
    }
    public function show($id)
    {

        $model = Reservation::where('id', $id)
            ->clubLawyer()
            ->first();

        return view('lawyer::dashboard.lawyers.dashboard.reservations.show', compact('model'));
    }
    public function destroy($id)
    {
        try {
            $delete = $this->lawyerClubRepository->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {

        try {
            $deleteSelected = $this->lawyerClubRepository->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
