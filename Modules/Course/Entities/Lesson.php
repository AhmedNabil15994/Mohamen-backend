<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use HasTranslations;
    use ScopesTrait;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = ['course_id', 'status', 'title'];
    public $translatable  = ['title'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessonContents()
    {
        return $this->hasMany(LessonContent::class)->oldest('order');
    }

    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }
}
