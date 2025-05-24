<?php

namespace Modules\Course\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseTarget;
use Modules\Course\Service\CourseService;
use Modules\Course\Service\CourseDateService;
use Modules\Course\Service\CourseTargetService;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class CourseRepository extends CrudRepository
{
    public VideoRepository     $videoRepository;

    public function __construct()
    {
        parent::__construct(Course::class);
        $this->videoRepository     = new VideoRepository();
        
    }


    public function modelCreateOrUpdate($model, $request, $is_created = true): void
    {
        $model->categories()->sync($request->categories);
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        if ($request->hasFile('intro_video')) {
            $this->videoRepository->uploadVideo($model, $request, 'intro_video');
        }
    }
    public function modelUpdated($model, $request): void
    {

        if ($request->hasFile('intro_video')) {
            $this->videoRepository->updateVideo($model, $request, 'intro_video');
        }
    }
}
