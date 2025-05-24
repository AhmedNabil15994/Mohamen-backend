<?php

namespace Modules\Service\Repositories\Dashboard;

use Modules\Service\Entities\Service;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ServiceRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Service::class);
    }
}
