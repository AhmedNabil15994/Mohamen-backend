<?php

namespace Modules\Report\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Club\Entities\Club;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\DataTable;
use Modules\Lawyer\Entities\Lawyer;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Report\Transformers\Dashboard\SaleReportResource;

class ReportRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Lawyer::class);
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->QueryTable($request));
        $datatable['data'] = SaleReportResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function QueryTable($request)
    {
        $query = $this->model->with('reservations')->withTotalReservationPrice()
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
        $this->appendFilter($query, $request);
        $orderBy = $request->columns[$request->order[0]['column']];
        $dir = $request->order[0]['dir'];
        return $query
            ->when($orderBy['name'] == 'title', fn ($q) => $q->orderBy('title->' . locale(), $dir));
    }
}
