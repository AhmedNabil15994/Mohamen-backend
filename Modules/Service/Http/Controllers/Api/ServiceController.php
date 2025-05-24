<?php

namespace Modules\Service\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Service\Transformers\Api\ServiceResource;
use Modules\Service\Repositories\Api\ServiceRepository as Service;
use Modules\Apps\Http\Controllers\Api\ApiController;

class ServiceController extends ApiController
{
    public $services;
    public function __construct(Service $services)
    {
        $this->services = $services;
    }

    public function index(Request $request)
    {
        $services =  $this->services->getPagination($request);
        return  ServiceResource::collection($services);
    }
}
