<?php

namespace Modules\Course\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Repositories\Frontend\LevelRepository;

class LevelController extends Controller
{
    public function __construct(LevelRepository $level)
    {
        $this->level    = $level;
    }

    public function levels()
    {
        $levels = $this->level->getLimitedLevels('id', 'asc');

        return view('course::frontend.levels.index', compact('levels'));
    }
    public function showLevel($id)
    {
        $level = $this->level->showLevel($id);

        return view('course::frontend.levels.show', compact('level'));
    }
}
