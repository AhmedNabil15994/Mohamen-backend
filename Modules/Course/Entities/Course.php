<?php

namespace Modules\Course\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Modules\Order\Entities\OrderCourse;
use Modules\User\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Course extends Model implements HasMedia
{
    use HasTranslations;
    use SoftDeletes;
    use ScopesTrait;
    use InteractsWithMedia;

    protected $fillable = ['title', 'desc', 'period', 'trainer', 'extra_attributes', 'price', 'status', 'category_id', 'instructor_id'];
    public $translatable = ['desc', 'title'];
    public $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];
    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorized', 'categorized');
    }
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function subscribed()
    {
        return $this->orderCourse()
            ->where('user_id', auth()->id())
            ->where(function ($q) {
                $q->whereNull('expired_date')->orWhere('expired_date', '>=', Carbon::now()->toDateTimeString());
            })->whereHas('order', function ($query) {
            $query->whereHas('orderStatus', function ($query) {
                $query->successPayment();
            });
        });
    }
    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }
    public function lessonContents()
    {
        return $this->hasManyThrough(LessonContent::class, Lesson::class);
    }
    /**
     * Get all of the orderCourses for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderCourses(): HasMany
    {
        return $this->hasMany(OrderCourse::class);
    }
    public function isFinished()
    {
        return $this->orderCourse()
            ->where(['user_id' => auth()->id(), 'is_watched' => 1])
            ->whereHas('order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                });
            })->count();
    }

    public function scopeIsSubscribed($query, $user_id = null)
    {
        return $query->withCount([
            "orderCourses as isSubscribed" => function ($query) use ($user_id) {
                $query->whereHas('order', function ($query) {
                    $query->whereHas('orderStatus', function ($query) {
                        $query->successPayment();
                    });
                })->where('user_id', $user_id);
            },
        ]);
    }

    public function scopeAuthCourses($q, $user_id)
    {
        return $q->when(
            request()->auth_courses == 1,
            fn($q) => $q->whereRelation(
                'orderCourses',
                "user_id",
                '=',
                $user_id
            )
        );
    }
    public function scopeFilter($q)
    {
        return $q->when(
            request()->category_id,
            fn($q) => $q->whereRelation(
                'categories',
                "categories.id",
                '=',
                request()->category_id
            )
        );
    }
}
