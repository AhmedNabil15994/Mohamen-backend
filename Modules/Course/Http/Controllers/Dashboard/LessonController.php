<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Course\Entities\Lesson;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;

class LessonController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }
    private $video_api;
    public function __construct(Lesson $lesson, CourseVideoApiRepository $videoApi,)
    {
        $this->__tConstruct();
        $this->model = $lesson;
        $this->video_api = $videoApi;
    }


    public function extraData($model)
    {
        return [
            'video_view' => $this->video_api->buildVideo(
                $model?->video?->video_link
            ),

        ];
    }
}
