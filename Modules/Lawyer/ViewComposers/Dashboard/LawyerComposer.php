<?php

namespace Modules\Lawyer\ViewComposers\Dashboard;

use Cache;
use Illuminate\View\View;
use Modules\Lawyer\Entities\Lawyer;

class LawyerComposer
{
    public $lawyers = [];

    public function __construct()
    {
        $this->lawyers =  Lawyer::active()->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('lawyers', $this->lawyers);
    }
}
