<?php

namespace Modules\Course\Repositories\Frontend;

use DB;
use Hash;
use Carbon\Carbon;
use AWS\CRT\HTTP\Request;
use Modules\Course\Entities\Level;
use Modules\Course\Entities\Course;

class LevelRepository
{
    public function __construct(Level $level)
    {
        $this->level   = $level;
    }



    public function getLimitedLevels($order = 'id', $sort = 'desc')
    {
        $levels = $this->level->orderBy($order, $sort)->with('courses')->take(24)->get();
        return $levels;
    }



    public function getAllLevels($order = 'id', $sort = 'desc')
    {
        return $this->level->orderBy($order, $sort)->paginate(24);
    }
    public function showLevel(int $id)
    {
        return $this->level->with(['courses'=>fn ($q) =>$q->withCount('lessons')])->findOrFail($id);
    }
}
