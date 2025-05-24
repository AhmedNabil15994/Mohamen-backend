<?php

view()->composer([
    'apps::frontend.index',
], Modules\Blog\ViewComposers\Frontend\BlogComposer::class);
