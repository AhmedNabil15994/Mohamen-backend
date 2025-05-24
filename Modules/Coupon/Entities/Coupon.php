<?php

namespace Modules\Coupon\Entities;

use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;
use Modules\Lawyer\Entities\Lawyer;

class Coupon extends Model
{
    protected $fillable = ['code', 'min', 'max', 'amount', 'is_fixed', 'current_use', 'max_use', 'max_use_user', 'expired_at', 'status', 'type'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeUnExpired($query)
    {
        $query->where('expired_at', '>', date('Y-m-d'));
    }

    public function scopeNotLimited($query)
    {
        $query->whereColumn('current_use', '<', "max_use");
    }

    public function checkAllow($price)
    {
        if ($this->min > $price) {
            return false;
        }
        return true;
    }

    public function applyCoupon($price)
    {
        $discount = $this->amount;

        if ($this->is_fixed) {
            return $discount;
        } else {
            $discount  = ($price / $discount) * $price;
        }

        return formatTotal($discount, 3);
    }

    public function scopeValidCoupon($query, $code)
    {
        return $query->unExpired()->active()->notLimited()
            ->where("code", $code);
    }


    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'coupon_courses',
            "coupon_id",
            'course_id',
        )->withTimestamps();
    }
    public function lawyers()
    {
        return $this->belongsToMany(
            Lawyer::class,
            'coupon_lawyers',
            "coupon_id",
            'lawyer_id',
        );
    }
}
