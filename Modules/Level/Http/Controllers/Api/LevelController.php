<?php

namespace Modules\Level\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Level\Transformers\Api\LevelResource;
use Modules\Level\Repositories\Api\LevelRepository as Level;
use Modules\Apps\Http\Controllers\Api\ApiController;

class LevelController extends ApiController
{
    public $levels;
    public function __construct(Level $levels)
    {
        $this->levels = $levels;
    }

    public function index(Request $request)
    {
        $levels =  $this->levels->getAllLevels($request);
        return $this->response(LevelResource::collection($levels));
    }
}
