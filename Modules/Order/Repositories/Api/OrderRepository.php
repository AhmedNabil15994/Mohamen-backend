<?php

namespace Modules\Order\Repositories\Api;

use Carbon\Carbon;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;
use Modules\Course\Entities\Course;
use Modules\Order\Entities\OrderStatus;

class OrderRepository
{

    public function __construct(Order $order, OrderStatus $status, Course $course)
    {
        $this->course = $course;
        $this->order  = $order;
        $this->status = $status;
    }

    public function getAllByUser()
    {
        return $this->order->where('user_id', auth()->id())->get();
    }

    public function findById($id)
    {
        return $this->order->where('id', $id)->first();
    }


    public function createOrder($course, $status = true)
    {
        DB::beginTransaction();
        try {
            $status = $this->statusOfOrder(false);

            $order = $this->order->create([
                'is_holding' => true,
                'discount' => 0.000,
                'subtotal' => $course['price'],
                'total' => $course['price'],
                'user_id' => auth()->id(),
                'order_status_id' => $status->id,
            ]);
            $this->orderCourse($order, $course);
            if (request()->code && $coupon = Coupon::validCoupon(request()->code)->first()) {
                $this->handelCoupon($order, $coupon);
            }


            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }





    public function orderCourse($order, $course)
    {
        $order->orderCourses()->create([
            'course_id'    => $course['id'],
            'total'        => $course['price'],
            'user_id'      => auth()->id(),
            'expired_date' => null,
        ]);
    }

    public function update($id, $boolean)
    {
        $order = $this->findById($id);

        $status = $this->statusOfOrder($boolean);

        $order->update([
            'is_hold' => false,
            'order_status_id' => $status['id']
        ]);

        foreach ($order->orderCourses()->get() as $course) :
            $this->updateCoursePeriod($course);
        endforeach;


        return $order;
    }

    private function updateCoursePeriod($order_courses): void
    {
        $course = $order_courses->course;

        if ($course->period) {
            $order_courses->update([
                'period' => $course->period,
                'expired_date' =>null,
            ]);
        }
    }

    public function statusOfOrder($type)
    {
        if ($type) {
            $status = $this->status->successPayment()->first();
        }

        if (!$type) {
            $status = $this->status->failedOrderStatus()->first();
        }

        return $status;
    }

    public function handelCoupon(&$order, $coupon)
    {
        $subtotal =  $order->subtotal;
        $order->update([
            'total' => ($order->subtotal - $coupon->applyCoupon($subtotal))
        ]);
        $order->coupons()->create([
            'code' => $coupon->code,
            'discount_type' => $coupon->is_fixed ? 'value' : 'percentage',
            'discount_percentage' => $subtotal > 0 ? (1 - ($order->total / $subtotal)) * 100 : null,
            'discount_value' => $subtotal - $order->total,
            'coupon_id' => $coupon->id,
        ]);

        return $order;
    }
}
