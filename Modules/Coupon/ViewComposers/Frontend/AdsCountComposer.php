<?php

namespace Modules\Coupon\ViewComposers\Frontend;

use Modules\Coupon\Repositories\Frontend\AdsRepository as Repo;
use Illuminate\View\View;

class AdsCountComposer
{
    public $adsCount = 0;

    public function __construct(Repo $repo)
    {
        $this->adsCount =  $repo->adsCount();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('adsCount', $this->adsCount);
    }
}
