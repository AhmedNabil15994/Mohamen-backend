<?php

namespace Modules\Course\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Course\Entities\Level;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class LevelRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Level::class);
        $this->fileAttribute=['image'=>'images','pdf'=>'pdf'];
        $this->statusAttribute=['require_start_exam','require_end_exam','paid'];
    }
}
