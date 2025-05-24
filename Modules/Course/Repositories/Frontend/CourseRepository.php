<?php

namespace Modules\Course\Repositories\Frontend;

use Modules\Course\Entities\Course;

class CourseRepository
{
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->paginate(24);

        return $courses;
    }

    public function getEventsByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->where('is_online', false)->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->paginate(24);

        return $courses;
    }

    public function getCoursesByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->where('is_online', true)->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->get();

        return $courses;
    }

    public function getLimitedEvents($order = 'id', $sort = 'desc')
    {
        $events = $this->course->where('is_online', false)->orderBy($order, $sort)->paginate(24);
        return $events;
    }

    public function getLimitedCourses($order = 'id', $sort = 'desc')
    {
        $courses = $this->course->orderBy($order, $sort)->take(24)->get();
        return $courses;
    }

    public function getAllEvents($order = 'id', $sort = 'desc')
    {
        $events = $this->course->where('is_online', false)->orderBy($order, $sort)->paginate(24);
        return $events;
    }

    public function getAllCourses($request, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->where(function ($query) use ($request) {
            if ($request->category_id) {
                $query->whereHas('categories', function ($query) use ($request) {
                    $query->where('category_id', $request->category_id);
                });
            }
        });
        // return $courses->orderBy($order, $sort)->paginate(24);
        return $courses->orderBy($order, $sort)->get();
    }
    public function getCoursesByGender($request, $gender = null, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->where('is_live', $request->has('live_courses'))
            ->withCount('orderCourse')
            ->when(
                $request->category_id,
                fn ($q) => $q->whereHas(
                    'categories',
                    fn ($q) => $q->where('categories.id', $request->category_id)
                )
            )
            ->when(
                $gender,
                fn ($q, $value) => $q->whereJsonContains('extra_attributes->gender', $value)
            )
            ->when(
                $request->search,
                fn ($q, $value) => $q->where(function ($q) use ($value) {
                    $q->where('title->en', $value)
                        ->orWhere('title->ar', $value);
                })
            );

        return $courses->orderBy($order, $sort)->get();
    }


    public function subscribedCourses($order = 'id', $sort = 'desc')
    {
        return $this->course->withCount('orderCourse')->whereHas('orderCourse.order', function ($query) {
            $query->whereHas('orderStatus', function ($query) {
                $query->successPayment();
            })->where('user_id', auth()->id());
        })->orderBy($order, $sort)->get();
    }
    public function subscribedLiveCourses($order = 'id', $sort = 'desc')
    {
        return $this->course->where('is_live', 1)->withCount('orderCourse')->whereHas('orderCourse.order', function ($query) {
            $query->whereHas('orderStatus', function ($query) {
                $query->successPayment();
            })->where('user_id', auth()->id());
        })->orderBy($order, $sort)->get();
    }

    public function findEventBySlug($slug)
    {
        return $this->course->where('slug->' . locale(), $slug)->first();
    }

    public function findCourseBySlug($slug)
    {
        return $this->course->withCount(
            'orderCourse',
            'lessons',
        )
            ->anyTranslation('slug', $slug)
            ->with('lessons.lessonContents', 'targets', 'meeting', 'activeCourseReviews', 'trainer')
            ->firstOrFail();
    }




    public function getCalendarCourses($order = 'id', $sort = 'desc')
    {
        return $this->course->where('is_live', 1)
            ->withCount('orderCourse')
            ->whereHas('orderCourse.order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                })->where('user_id', auth()->id());
            })
            ->orWhere('trainer_id', auth()->id())
            ->where('is_live', 1)
            ->orderBy($order, $sort)->get();
    }
}
