<?php

namespace Modules\Level\Repositories\Api;

use Modules\Level\Entities\Level;
use Modules\Core\Repositories\Api\ApiCrudRepository;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class LevelRepository extends ApiCrudRepository
{
    public function getAllLevels()
    {
        return Level::orderBy('winning_count','desc')->get();
    }
}
