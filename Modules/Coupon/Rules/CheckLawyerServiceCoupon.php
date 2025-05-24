<?php

namespace Modules\Coupon\Rules;

use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Entities\Package;
use Illuminate\Contracts\Validation\Rule;
use Modules\Course\Entities\Course;
use Modules\Service\Entities\LawyerService;

class CheckLawyerServiceCoupon implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public $lawyer_id, public $service_id)
    {
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
        $coupon = Coupon::unExpired()->active()->notLimited()
            ->where("code", $value)->whereHas('lawyers', function ($query) {
                return $query->where('lawyer_id', $this->lawyer_id);
            })->first();
        if (!$coupon) return false;
        $service = LawyerService::where(
            ['service_id' => $this->service_id],
            ['lawyer_id' => $this->lawyer_id]
        )->first();

        return $coupon->checkAllow($service->price);
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
