<?php

return [
    'reservations' => [
        'datatable' => [
            'created_at'        => 'Created At',
            'date_range'        => 'Search By Dates',
            'days_number'       => 'Days Number',
            'options'           => 'Options',
            'owners'            => 'owners',
            'cities'            => 'cities',
            'service'             => 'service',
            'lawyer'             => 'lawyer',
            'user'             => 'user',
            'club'              => 'club',
            'club_owner'        => 'club owner',
            'organizer'         => ' organizer',
            'organizer_mobile'  => 'organizer mobile',
            'reservation_date'  => 'Reservation Date',
            'reservation_time'  => 'Reservation Time',

            'city'          => 'city',
            'mobile'            => 'Mobile Number',
            'lawyer_details'    => 'Lawyer Details',
            'user_details'      => 'Client Details',
            'name'              => 'Name',
            'paid'       => [
                'title'  => 'paid status',
                'pending' => 'pending',
                'failed' => 'payment failed',
                'paid'   => 'paid',
            ],
            'paid_by_admin' => 'Paid By Admin',
        ],
        'show' => [
            'tabs' => [
                'general' => 'general info'
            ],
            'times' => [
                'title' => 'reservation times',
                'from'  => 'from ',
                'to'    => 'to',
                'price' => 'price',
            ]
        ],
        'routes' => [
            'index' => 'reservations',
            'show' => 'show reservation',
        ],
    ],
    'reservations_calendar' => [
        'routes' => [
            'index' => 'reservation calendars',
        ],
        'delete_btn' => 'do you want to delete reservation ? ',
        'form' => [
            'title'  => 'New Reservation',
            'btn'    => 'save',
            'name'   => 'enter name',
            'mobile' => 'enter mobile',
        ],
        'select' => 'Select',
    ],

];
