<?php

return [
    'coupons'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            "code"         => "Code",
            'min'              => 'Min value',
            'max'               => 'Max value when percent',
            "amount"            => "Discount",
            "expired_at"        => "expired at",
            "max_use"           => "Max use",
            "current_use"       => "Current use",
            "max_use_user"      => "Max use user",
            "is_fixed"          => "Is fixed",

        ],
        'form'      => [
            'status'        => 'Status',
            "code"         => "Code",
            'min'              => 'Min value',
            'max'               => 'Max value when percent',
            "amount"            => "Discount",
            "expired_at"        => "expired at",
            "max_use"           => "Max use",
            "current_use"       => "Current use",
            "max_use_user"      => "Max use user",
            "is_fixed"          => "Is fixed",
            "courses"           => "courses",
            'tabs'              => [
                'general'   => 'General Info.',
            ],
            'type'            => 'type',
            'types' => [
                'courses' => 'courses',
                'lawyers' => 'lawyers',
            ],

        ],
        'routes'    => [
            'create'    => 'Create Coupon',
            'index'     => ' Coupons ',
            'update'    => 'Edit Coupon',
        ],
        'validation' => [
            "not_valid" => "Coupon No Valid"
        ],
    ],

];
