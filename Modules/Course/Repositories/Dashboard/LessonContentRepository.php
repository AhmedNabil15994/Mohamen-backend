<?php

namespace Modules\Course\Repositories\Dashboard;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Modules\Course\Entities\LessonContent;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Course\Entities\Video;

class LessonContentRepository extends CrudRepository
{
    public VideoRepository $videoRepository;
    public function __construct()
    {
        parent::__construct(LessonContent::class);
        $this->fileAttribute=['resource'=>'resources'];
        $this->videoRepository=new VideoRepository();
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if ($request->type!=='exam') {
            Arr::pull($data, 'exam_id', null);
        }
        return $data;
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        if ($request->type =='video') {
            $this->videoRepository->uploadVideo($model, $request, 'video');
        }
    }

    public function modelUpdated($model, $request): void
    {
        if ($request->video&&$request['type'] =='video') {
            $this->videoRepository->updateVideo($model, $request, 'video');
        }

        if ($request['type']=='resource') {
            $model->update(['exam_id'=>null]);
        }

        if ($request['type']=='exam') {
            //reset video
            $model->clearMediaCollection('resources');
        }
    }

    public function restVideo($model)
    {
        //todoList implement  function to delete video from database and video service
    }
    public function restExam($model)
    {
        $model->update(['exam_id'=>null]);
    }
}



/**
 * when to delete video
 * case 1 we have another one
 * case 2 we have another type
 */
/**
 * when to reset exam_id
 * case 1 we have another type
 */

/**
 * when to reset resource
 * case 1 we have another type
 */
