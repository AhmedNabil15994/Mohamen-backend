<?php

namespace Modules\Lawyer\Http\Controllers\Dashboard;

use Illuminate\Support\Arr;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use Modules\Lawyer\Entities\Lawyer;
use Modules\Core\Traits\WorkingWithTimeTrait;
use Modules\Availability\Entities\Availability;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Service\Repositories\Dashboard\ServiceRepository;
use Modules\Availability\Transformers\Api\AvailabilityResource;
use Modules\Category\Repositories\Dashboard\CategoryRepository;

class LawyerController extends Controller
{
    use CrudDashboardController;

    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }

    use WorkingWithTimeTrait;

    public $categoryRepository;
    public $serviceRepository;

    public function __construct(CategoryRepository $categoryRepository, ServiceRepository $serviceRepository)
    {
        $this->__tConstruct();
        $this->categoryRepository = $categoryRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function extraData($model)
    {
        $countries = Country::with('cities')->get()->transform(function ($country) {
            return [$country->title => $country->cities->pluck('title', 'id')];
        });
        return [
            'categories' => $this->categoryRepository->mainCategories()->pluck('title', 'id'),
            'services' => $this->serviceRepository->getAllActive(),
            'countries' => Arr::collapse($countries)
        ];
    }

    public function ajaxServices(Request $request)
    {
        $lawyer = Lawyer::findOrFail($request->id);

        $output = '';
        foreach($lawyer->services as $service)
        {
            $output .= '<option value="'.$service->id.'">'.$service->title.'</option>';
        }

        return [
            'html' => $output
        ];
    }

    public function ajaxAvailableTimes(Request $request)
    {
        $dayCode = getDayCode($request->date);
        $lawyer = Lawyer::findOrFail($request->id);

        if ($lawyer->isClosedOn($request->date)) {
            return ['html' => __('lawyer::Api.messages.is_closed_message') ];
        }

        $availability = Availability::modelAndDay($request->id, $dayCode, Lawyer::class)->first();

        $times = $this->getTimes($availability);

        $output = '';
        if( !is_null($times) )
        {
            $output .= "<div class='row'>";
            foreach($times as $time)
            {
                $output .= "<div class='p-2'><div class='col-md-4 bg-info' style='margin: 5px; border: solid 1px #ccc'>
                <input type='radio' name='time' id='id".Str::slug($time['from'].$time['to'])."' value='".$time['from']." - ".$time['to']."'>
                <label for='id".Str::slug($time['from'].$time['to'])."'><small>".$time['from']." <br /> ".$time['to']."</small></label>
                </div></div>";
            }
            $output .="</div>";
        } else {
            $output = "ﻻ توجد مواعيد متاحة";
        }

        return [
            'html' => $output
        ];
    }
}
