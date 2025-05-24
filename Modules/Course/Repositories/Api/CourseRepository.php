<?php

namespace Modules\Course\Repositories\Api;

use Modules\Core\Repositories\Api\ApiCrudRepository;
use Modules\Course\Entities\Course;

class CourseRepository extends ApiCrudRepository
{
    public function __construct()
    {
        parent::__construct(Course::class);
    }
    public function getModel()
    {
        return $this->model
            ->isSubscribed(auth('sanctum')->id())
            ->active()
            ->filter()
            ->authCourses(auth('sanctum')->id())
            ->with('lessons');
    }
}
