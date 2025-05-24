<?php

namespace Modules\Report\ViewComposers\Dashboard;

use Cache;
use Illuminate\View\View;
use Modules\Report\Repositories\Dashboard\OrderRepository;

class OrderComposer
{
    public function __construct(OrderRepository $order)
    {
        $this->orders = $order->completeOrders();
        $this->monthlyOrders = $order->monthlyOrders();
        $this->totalProfit = $order->totalProfit();
        $this->todayProfit = $order->totalTodayProfit();
        $this->monthProfit = $order->totalMonthProfit();
        $this->yearProfit = $order->totalYearProfit();
        $this->orders_count = $order->getOrdersQuery()->count();

        $this->orders_total = $order->getOrdersQuery()->paid()->sum('total');
    }

    public function compose(View $view)
    {
        $view->with('monthlyOrders', $this->monthlyOrders);
        $view->with('totalProfit', $this->totalProfit);
        $view->with('completeOrders', $this->orders);
        $view->with('orders_count', $this->orders_count);
        $view->with('orders_total', $this->orders_total);
        $view->with([
            "todayProfit" => $this->todayProfit,
            "monthProfit" => $this->monthProfit,
            "yearProfit" => $this->yearProfit
        ]);
    }
}
