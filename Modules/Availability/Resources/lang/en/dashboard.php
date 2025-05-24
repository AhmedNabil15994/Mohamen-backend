<?php

return [
    'availabilities'        => [
        'form'      => [
            'availabilities'  => 'availabilities',
            'time'            => 'time',
            'day'             => 'day',
            'price'           => 'price',
            'days'  =>  [
                'sat'   =>  'saturday',
                'sun'   =>  'sunday',
                'mon'   =>  'monday',
                'tue'   =>  'tuesday',
                'wed'   =>  'wednesday',
                'thu'   =>  'thursday',
                'fri'   =>  'friday',
            ],
            'btn_more' => 'Add More',
            'full_time' => '24 hours',
            'custom_time' => 'custom time ',
            'overlapping' => 'time exist in other range',
            'time_greater_than' => 'start must be greater than end',
        ],
    ],
    'vacations' => [
        'title' => 'vacations',
        'form' => [
            'weekly_vacations' => 'weekly vacations',
            'custom_vacations' => 'custom vacations',
            'date_range' => 'date range',
            'add_more' => 'add more',
        ]
    ]
];
