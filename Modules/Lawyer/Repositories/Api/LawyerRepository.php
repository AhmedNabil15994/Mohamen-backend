<?php

namespace Modules\Lawyer\Repositories\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Lawyer\Entities\Lawyer;
use Modules\Availability\Entities\Availability;
use Modules\Core\Repositories\Api\ApiCrudRepository;

class LawyerRepository extends ApiCrudRepository
{

    public function __construct()
    {
        parent::__construct(Lawyer::class);
    }
    public function getModel()
    {
        return $this->model->filterApi();
    }

    public function findById($id)
    {

        return  $this->getModel()->active()->find($id);
    }
    public function findLawyerAvailabilitiesByDate($id, $date)
    {
        $dayCode = getDayCode($date);

        return  Availability::modelAndDay($id, $dayCode, Lawyer::class)->first();
    }
}
