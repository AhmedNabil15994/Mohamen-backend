<?php

namespace Modules\Lawyer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Availability\Transformers\Api\AvailabilityResource;
use Modules\Core\Traits\WorkingWithTimeTrait;
use Modules\Lawyer\Http\Requests\Api\GetAvailabilityRequest;
use Modules\Lawyer\Repositories\Api\LawyerRepository;
use Modules\Lawyer\Transformers\Api\LawyerResource;
use Modules\Lawyer\Transformers\Api\LawyerServiceResource;

class LawyerController extends ApiController
{
    use WorkingWithTimeTrait;

    private $lawyerRepository;

    public function __construct(LawyerRepository $lawyerRepository)
    {
        $this->lawyerRepository = $lawyerRepository;
    }

    public function index(Request $request)
    {

        return LawyerResource::collection($this->lawyerRepository->getPagination($request));
    }
    public function services($id)
    {
        /* $services = $this->lawyerRepository
        ->findById($id)
        ->load(['services' => fn($q) => $q->wherePivot('price', '!=', null)])?->services; */

        $lawyer = $this->lawyerRepository
            ->findById($id);
        if (!$lawyer) {
            return $this->response(null);
        }

        $services = $lawyer->load(['services' => fn($q) => $q->wherePivot('price', '!=', null)])?->services;
        return LawyerServiceResource::collection($services);
    }

    public function findLawyerAvailabilities(GetAvailabilityRequest $request)
    {

        $lawyer = $this->lawyerRepository->findById($request->lawyer_id);
        if ($lawyer->isClosedOn($request->date)) {
            return $this->error( __('lawyer::Api.messages.is_closed_message'));
        }
        $availability =
        $this->lawyerRepository->findLawyerAvailabilitiesByDate(
            $request->lawyer_id,
            $request->date
        );

        $availability['times'] =
        $availability ? $this->availableTimes($availability, $request->date) : null;
        return $this->response($availability['times'] ? new AvailabilityResource($availability) : null);
    }
}
