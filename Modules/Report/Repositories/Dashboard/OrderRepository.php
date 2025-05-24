<?php

namespace Modules\Report\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Reservation\Entities\Reservation;

class OrderRepository
{
    protected $order;

    public function __construct(Reservation $order)
    {
        $this->order = $order;
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order->paid()
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"))
            ->pluck('date');

        $ordersIncome = $this->order
            ->paid()
            ->select(DB::raw("sum(total) as profit"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }



    public function getOrdersQuery()
    {
        return $this->order->where(function ($query) {
            if (request()->get('from')) {
                $query->whereDate('created_at', '>=', request()->get('from'));
            }

            if (request()->get('to')) {
                $query->whereDate('created_at', '<=', request()->get('to'));
            }
        });
    }

    public function totalTodayProfit()
    {
        return $this->order
            ->paid()
            ->whereDate("created_at", \DB::raw('CURDATE()'))
            ->sum('total');
    }

    public function totalMonthProfit()
    {
        return $this->order
            ->paid()
            ->whereMonth("created_at", date("m"))
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function totalYearProfit()
    {
        return $this->order->paid()
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function completeOrders()
    {
        $orders = $this->order->paid()->count();

        return $orders;
    }

    public function totalProfit()
    {
        return $this->order->paid()->sum('total');
    }
}
