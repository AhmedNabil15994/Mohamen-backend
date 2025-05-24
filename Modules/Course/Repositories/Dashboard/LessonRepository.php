<?php

namespace Modules\Course\Repositories\Dashboard;

use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Course\Entities\Lesson;
use Modules\Course\Repositories\Dashboard\VideoRepository;

class LessonRepository extends CrudRepository
{
    public VideoRepository     $videoRepository;

    public function __construct()
    {
        parent::__construct(Lesson::class);
        $this->videoRepository     = new VideoRepository();
    }
    public function modelCreated($model, $request, $is_created = true): void
    {
        if ($request->hasFile('video')) {
            $this->videoRepository->uploadVideo($model, $request, 'video');
        }
    }
    public function modelUpdated($model, $request): void
    {

        if ($request->hasFile('video')) {
            $this->videoRepository->updateVideo($model, $request, 'video');
        }
    }
}
