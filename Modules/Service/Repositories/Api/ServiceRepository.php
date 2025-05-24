<?php

namespace Modules\Service\Repositories\Api;


use Modules\Service\Entities\Service;
use Modules\Core\Repositories\Api\ApiCrudRepository;

class ServiceRepository extends ApiCrudRepository
{
    public function __construct()
    {
        parent::__construct(Service::class);
    }
}
