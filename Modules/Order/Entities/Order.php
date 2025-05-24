<?php

namespace Modules\Order\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Coupon\Entities\CouponOrder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    use ScopesTrait;

    protected $fillable = [
        'total',
        'unread',
        'subtotal',
        'discount',
        'user_id',
        'address_id',
        'is_holding',
        'order_status_id',
        'period',
    ];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function orderCourses()
    {
        return $this->hasMany(OrderCourse::class);
    }


    public function coupons()
    {
        return $this->hasMany(CouponOrder::class, 'order_id');
    }
}
