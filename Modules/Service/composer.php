<?php

view()->composer([
    'apps::frontend.index',
], Modules\Service\ViewComposers\Frontend\ServiceComposer::class);
