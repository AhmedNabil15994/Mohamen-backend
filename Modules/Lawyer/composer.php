<?php

use Modules\Lawyer\ViewComposers\Dashboard\LawyerComposer;



view()->composer([
  'reservation::dashboard.reservations.index',
], LawyerComposer::class);
