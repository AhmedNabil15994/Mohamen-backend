<?php

namespace Modules\Order\Entities;

use Modules\User\Entities\User;
use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;

class OrderCourse extends Model
{
    protected $fillable = [
      'price',
      'off',
      'qty',
      'total',
      'course_id',
      'order_id',
      'user_id',
      'expired_date',
      'period',
      'trainer_id',
      'is_watched',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class)->withTrashed();
    }


    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
