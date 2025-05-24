<?php

//view()->composer(['area::dashboard.cities.*'], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);
//
//view()->composer([
//    'area::dashboard.states.*','company::dashboard.companies.*'
//], \Modules\Area\ViewComposers\Dashboard\CityComposer::class);
//
view()->composer(['reservation::dashboard.reservations.index'],
\Modules\Area\ViewComposers\Dashboard\CityComposer::class);
