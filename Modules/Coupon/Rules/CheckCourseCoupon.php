<?php

namespace Modules\Coupon\Rules;

use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Entities\Package;
use Illuminate\Contracts\Validation\Rule;
use Modules\Course\Entities\Course;

class CheckCourseCoupon implements Rule
{
    public $course_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($course_id)
    {

        $this->course_id = $course_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $course = Course::find($this->course_id);
        $coupon = Coupon::unExpired()->active()->notLimited()
            ->where("code", $value)->whereHas('courses', function ($query) {
                return $query->where('course_id', $this->course_id);
            })->first();
        if (!$coupon) return false;
        return $coupon->checkAllow($course->price);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("coupon::api.coupons.validation.not_validCoupon");
    }
}
