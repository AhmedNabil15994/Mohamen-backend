<?php

namespace Modules\Reservation\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Reservation\Entities\Reservation;

class ReservationRepository extends CrudRepository
{


    
    public function filterDataTable($query, $request)
    {
        $query=parent::filterDataTable($query, $request);
        if (isset($request['req']['owners']) && $request['req']['owners'] != '') {
            $query->whereHas('club.owner', function ($query) use ($request) {
                $query->where('id', $request['req']['owners']);
            });
        }
        if (isset($request['req']['city']) && $request['req']['city'] != '') {
            $query->whereHas('club.city', function ($query) use ($request) {
                $query->where('id', $request['req']['city']);
            });
        }
        if (isset($request['req']['club']) && $request['req']['club'] != '') {
            $query->whereHas('club', function ($query) use ($request) {
                $query->where('id', $request['req']['club']);
            });
        }

        return $query;
    }
}
