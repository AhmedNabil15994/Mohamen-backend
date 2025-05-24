<?php

use Modules\Authorization\ViewComposers\Dashboard\AdminRolesComposer;
use Modules\Authorization\ViewComposers\Dashboard\LawyerRolesComposer;

view()->composer([
  'user::dashboard.admins.index',
], AdminRolesComposer::class);
view()->composer([
    'lawyer::dashboard.lawyers.index',
], LawyerRolesComposer::class);
