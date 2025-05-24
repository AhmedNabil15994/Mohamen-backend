<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Course\Traits\VdocipherIntegration;
use Modules\Course\Transformers\Api\CourseResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Course\Repositories\Api\CourseRepository as Course;

class CourseController extends ApiController
{
    use VdocipherIntegration;
    public $courses;
    public function __construct(Course $courses)
    {
        $this->courses = $courses;
    }

    public function index(Request $request)
    {
        $courses =  $this->courses->getPagination($request);
        return  CourseResource::collection($courses);
    }
    public function show($id)
    {
        $courses =  $this->courses->findById($id);
        return  $this->response(new CourseResource($courses));
    }


    public function getVideoInfo($id)
    {
        $response = $this->getOtp($id)->getData()->data;


        $otp = data_get($response, 'otp');
        $playbackInfo = data_get($response, 'playbackInfo');


        return $this->response(compact('otp', 'playbackInfo'));
    }
}
