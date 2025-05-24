<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Illuminate\Support\Arr;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Video;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\LessonContent;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;

class LessonContentController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }
    private $video_api;

    public function __construct(LessonContent $model, CourseVideoApiRepository $videoApi)
    {
        $this->__tConstruct();
        $this->model = $model;
        $this->video_api = $videoApi;
    }


    public function extraData($model)
    {
        $courses = Course::with('lessons')
        
            ->withCount('lessons')
            ->orderBy('lessons_count', 'desc')
            ->get()
            ->transform(function ($course) {
                return [$course->title => $course->lessons->pluck('title', 'id')];
            });

        return ['video_view' => $this->video_api->buildVideo(optional($model->video)->video_link), 'courses' => Arr::collapse($courses)];
    }
}
