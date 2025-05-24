<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Modules\Course\Repositories\Dashboard\CourseVideoApiRepository;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Video extends Model implements HasMedia
{
    use ScopesTrait;
    use InteractsWithMedia;

    protected $fillable = ['thumb', 'video_link', 'video_length', 'status', 'loading_status'];

    public $appends = ['video_minutes'];
    public function scopeActive($query)
    {
        return $query->where('status', true)->where(function ($q) {
            $q->where('loading_status', 'loaded');
        });
    }

    public function credential()
    {
        return $this->hasOne(ObtainCredential::class, 'api_video_id', 'video_link');
    }

    public function getVideoStatusAttribute()
    {



        if (optional($this->credential)->status == 'pending') {

            $videoStatus = CourseVideoApiRepository::checkVideoStatus($this->video_link);
            $response = (new CourseVideoApiRepository())->getVideos($this->video_link);

            $duration = data_get($response->getOriginalContent(), 'data.0.length');
            $thumb = data_get($response->getOriginalContent(), 'data.0.posters.0.posterUrl');



            if ($videoStatus && $videoStatus == 'ready') {
                $this->credential()->update(['status' => 'loaded']);
                $this->update(['video_length' => $duration, 'thumb' => $thumb]);
                return 'loaded';
            }
        }
        return optional($this->credential)->status;
    }


    public function videoable()
    {
        return $this->morphTo();
    }


    public function getVideoMinutesAttribute()
    {
        $init = $this->video_length;
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;

        return "$hours:$minutes:$seconds";
    }
}
