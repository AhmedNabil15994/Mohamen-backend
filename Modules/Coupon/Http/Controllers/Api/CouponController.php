<?php

namespace Modules\Coupon\Http\Controllers\Api;

use Illuminate\Http\Request;

use Modules\User\Enums\UserType;

use Modules\Coupon\Entities\Coupon;

use Modules\Course\Entities\Course;
use Modules\Service\Entities\LawyerService;
use Modules\Coupon\Transformers\Api\AdsResource;
use Modules\Coupon\Http\Requests\Api\CouponRequest;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Coupon\Http\Requests\Api\LawyerCouponRequest;
use Modules\Coupon\Repositories\Api\CouponRepository as Repo;
use Modules\User\Transformers\Api\UserResource as ModelResource;

class CouponController extends ApiController
{
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function check(CouponRequest $request)
    {

        $course = Course::where('id', $request->course_id)->first();
        $coupon = Coupon::where('code', $request->code)->first();
        $price = $course->price;

        $values = [
            'original_price' =>  $price,
            'after_apply_coupon_price' => (string)($price - $coupon->applyCoupon($price)),
        ];

        return $this->response($values);
    }
    public function checkLawyerCoupon(LawyerCouponRequest $request)
    {
        $service = LawyerService::where(
            ['service_id' => $request->service_id],
            ['lawyer_id' => $request->lawyer_id]
        )->first();
        $coupon = Coupon::where('code', $request->code)->first();
        $price = $service->price;
        $values = [
            'original_price' =>  $price,
            'after_apply_coupon_price' => (string)($price - $coupon->applyCoupon($price)),
        ];
        return $this->response($values);
    }
}
