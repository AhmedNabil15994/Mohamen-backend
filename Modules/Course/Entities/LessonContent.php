<?php

namespace Modules\Course\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Exam\Entities\Exam;
use Spatie\MediaLibrary\HasMedia;

class LessonContent extends Model implements HasMedia
{
    use HasTranslations;
    use ScopesTrait;
    use InteractsWithMedia;

    public $fillable = ['title', 'order', 'type', 'lesson_id'];
    public $translatable  = ['title'];

    public function scopeActive($query)
    {
        return $query->where('status', true)->where(function ($q) {
            $q->where('loading_status', 'loaded');
        });
    }


    /**
     * Get the user that owns the LessonContent
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }


    /**
     * Get the user that owns the LessonContent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
