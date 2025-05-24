<?php

namespace Modules\Coupon\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        $rule =  [
            "code"       => "required|unique:coupons,id",
            "amount"     => "required|min:1",
            "max_use"    => "required|integer|min:1",
            "max_use_user"    => "required|integer|max:" . $this->max_use,
            "expired_at"     => "required|date|after_or_equal:today",
            "courses"     => "exclude_if:type,lawyers|required|array",
            "lawyers"     => "exclude_if:type,courses|required|array",
            "courses.*"     => "required|exists:courses,id",
            'type' => 'required',
            "lawyers.*"     => "required|exists:users,id",
        ];


        if ($this->is_fixed == null) {
            $rule["amount"]       =  'required|integer|max:100|min:1';
        }
        if (strtolower($this->getMethod()) == "put") {
            $rule["expired_at"] = "required";
            $rule["code"]       =   $rule["code"] . "," . $this->id;
        }
        return $rule;
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
