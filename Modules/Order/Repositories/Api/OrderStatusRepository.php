<?php

namespace Modules\Order\Repositories\Api;

use Modules\Order\Entities\OrderStatus;

class OrderStatusRepository
{
    public function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus   = $orderStatus;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orderStatuses = $this->orderStatus->orderBy($order, $sort)->get();
        return $orderStatuses;
    }

    public function getAllFinalStatus($order = 'id', $sort = 'desc')
    {
        $orderStatuses = $this->orderStatus->finalStatus()->orderBy($order, $sort)->get();
        return $orderStatuses;
    }
}
