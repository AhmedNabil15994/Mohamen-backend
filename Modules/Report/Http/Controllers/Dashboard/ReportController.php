<?php

namespace Modules\Report\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Report\Http\Requests\Dashboard\ReportRequest;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Report\Repositories\Dashboard\ReportRepository;

class ReportController extends Controller
{
    public $reportRepository;
    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->middleware('permission:sales_report_by_lawyer');
    }


    public function salesReport(Request $request)
    {

        if (request()->ajax()) {
            return $this->reportRepository->datatable($request);
        }
        return view('report::dashboard.reports.sales-reports.index');
    }
}
