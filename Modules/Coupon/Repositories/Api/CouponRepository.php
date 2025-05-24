<?php

namespace Modules\Coupon\Repositories\Api;

use Modules\Category\Entities\Category;
use Modules\Coupon\Entities\Coupon as Model;

class CouponRepository
{
    public function __construct(Model $model)
    {
        $this->model   = $model;
    }
    public function findByCode($code)
    {
        return $this->model;
    }
}
