<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Course\Repositories\Api\CourseRepository as Course;
use Modules\Order\Http\Requests\Api\CreateOrderRequest;
use Modules\Order\Repositories\Api\OrderRepository as Order;
use Modules\Transaction\Services\PaymentService;

class OrderController extends ApiController {

  public function __construct(public Order $order, public PaymentService $payment, public Course $course) {
  }

  public function store(CreateOrderRequest $request) {

    $course = $this->course->findById($request['course_id']);
    if ($course->isSubscribed > 0) {
      return $this->error(__('apps::api.messages.duplicated_order'));
    }
    $order = $this->order->createOrder($course);
    $url   = $this->payment->send($order, 'api-order', 'Knet');

    return $this->response(['paymentUrls' => $url]);
  }

  public function success(Request $request) {
    $this->order->update($request['OrderID'], true);
    return $this->response([], message: __('apps::api.messages.success'));
  }

  public function failed(Request $request) {
    return $this->error(__('apps::api.messages.failed'));
  }
}
