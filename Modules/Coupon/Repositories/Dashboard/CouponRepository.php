<?php

namespace Modules\Coupon\Repositories\Dashboard;

use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Coupon\Entities\Coupon;

class CouponRepository extends CrudRepository {

  public function __construct() {
    parent::__construct(Coupon::class);
    $this->statusAttribute = ['status', 'is_fixed'];
  }

  public function getStatistics() {
    $count = $this->model->count();
    return ["count" => $count];
  }
  public function modelCreateOrUpdate($model, $request, $is_created = true): void {
    if ('courses' == $model->type) {
      $model->courses()->sync($request['courses']);
      $model->lawyers()->detach();
    } else {
      $model->lawyers()->sync($request['lawyers']);
      $model->courses()->detach();
    }
  }
}
