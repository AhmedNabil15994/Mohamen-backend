<?php

namespace Modules\Service\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Modules\Service\Repositories\Frontend\ServiceRepository as Service;

class ServiceController extends Controller
{
    public $service;
    public function __construct(Service $service)
    {
        $this->service    = $service;
    }

    public function index()
    {
        $services = $this->service->getAllServices();

        return view('service::frontend.index', compact('services'));
    }

    public function mediaCenter()
    {
        $services = $this->service->getAllMediaCenter();

        return view('service::frontend.media_center', compact('services'));
    }

    public function show($slug)
    {
        $service = $this->service->findBySlug($slug);

        if (!checkRouteLocale($service, $slug)) {
            return redirect()->route(Route::currentRouteName(), [$service->slug]);
        }



        return view('service::frontend.show', compact('service'));
    }
}
