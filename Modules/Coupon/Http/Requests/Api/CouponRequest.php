<?php

namespace Modules\Coupon\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Entities\Package;
use Modules\Coupon\Rules\CheckCoupon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Coupon\Rules\CheckCourseCoupon;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return   [
            'course_id' => 'required',
            'code' =>
            [
                'required',
                Rule::exists("coupons", "code"), new CheckCourseCoupon($this->course_id)
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
