<?php

namespace Modules\Coupon\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Course\Repositories\Dashboard\CourseRepository;
use Modules\Lawyer\Repositories\Dashboard\LawyerRepository;

class CouponController extends Controller {

  use CrudDashboardController;

  public function extraData($model) {
    return
      [
      'courses' => app(CourseRepository::class)->getAllActive(),
      'lawyers' => app(LawyerRepository::class)->getAll(),
    ];
  }
}
