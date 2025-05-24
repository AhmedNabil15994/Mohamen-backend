<?php

namespace Modules\Lawyer\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Lawyer\Entities\Lawyer;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\DataTable;
use Modules\Reservation\Entities\Reservation;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Reservation\Transformers\Dashboard\ReservationResource;

class LawyerClubRepository
{
    public function datatable(Request $request, $clubId)
    {
        $datatable = DataTable::drawTable($request, $this->QueryTable($request, $clubId));


        $datatable['data'] = ReservationResource::collection($datatable['data']);

        return Response()->json($datatable);
    }



    public function QueryTable($request, $clubId)
    {
        $query = Reservation::where('club_id', $clubId)->whereHas('club.lawyer', fn ($q) => $q->where('id', auth()->id()))
            ->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
                $this->appendSearch($query, $request);
                foreach ($this->getModelTranslatable() as $key) {
                    $query->orWhere($key . '->' . locale(), 'like', '%' . $request->input('search.value') . '%');
                }
            });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        } else {
            if (isset($request['req']['from']) && $request['req']['from'] != '') {
                $query->whereDate('created_at', '>=', $request['req']['from']);
            }

            if (isset($request['req']['to']) && $request['req']['to'] != '') {
                $query->whereDate('created_at', '<=', $request['req']['to']);
            }

            if (isset($request['req']['status']) && $request['req']['status'] == '1') {
                $query->active();
            }

            if (isset($request['req']['status']) && $request['req']['status'] == '0') {
                $query->unactive();
            }
        }



        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        // call append filter
        $this->appendFilter($query, $request);

        return $query;
    }

    public function appendSearch(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        return $query;
    }
    public function getModelTranslatable()
    {
        if (property_exists(new Reservation(), 'translatable')) {
            return (new Reservation())->translatable;
        } else {
            return [];
        }
    }
    /**
     * Append custom filter
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function appendFilter(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        return $query;
    }




    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = Reservation::where('id', $id)->clubLawyer()->first();
            $model->delete();
            DB::commit();
            $this->commitedAction($model, $request = null, "delete");
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $this->delete($id);
            }

            DB::commit();
            $this->commitedAction(null, $request, "multi_delete");
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    /**
     * Model commited call back function
     *
     * @param mixed $model
     * @param \Illuminate\Http\Request $request
     * @param string $event_type is created flag
     * @return void
     */
    public function commitedAction($model, $request, $event_type = "create"): void
    {
    }
}
