<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Category\Repositories\Dashboard\CategoryRepository;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;

class CourseController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __tConstruct;
    }
    private $video_api;
    private $categoryRepository;

    public function __construct(Course $course, CourseVideoApiRepository $videoApi, CategoryRepository $categoryRepository)
    {
        $this->__tConstruct();
        $this->model = $course;
        $this->video_api = $videoApi;
        $this->categoryRepository = $categoryRepository;
    }


    public function extraData($model)
    {
        return [
            'video_view' => $this->video_api->buildVideo(
                optional($model->video)->video_link
            ),
            'categories' => $this->categoryRepository->mainCategories()->pluck('title', 'id'),
            'instructors' => User::whereHas('roles.permissions', function ($query) {
                $query->where('name', 'instructor');
            })->pluck('name', 'id')
        ];
    }
}
