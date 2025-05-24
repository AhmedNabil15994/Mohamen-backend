<?php

namespace Modules\Area\Http\Controllers\Dashboard;


use Illuminate\Support\Arr;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class StateController extends Controller
{
    use CrudDashboardController;

    public function extraData($model)
    {
        $countries = Country::with('cities')->get()->transform(function ($country) {
            return [$country->title => $country->cities->pluck('title', 'id')];
        });
        return ['countries' => Arr::collapse($countries)];
    }
}
