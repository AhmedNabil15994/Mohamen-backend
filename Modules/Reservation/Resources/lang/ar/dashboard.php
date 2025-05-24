<?php

return [
    'reservations' => [
        'datatable' => [
            'created_at'        => 'تاريخ الآنشاء',
            'date_range'        => 'البحث بالتواريخ',
            'owners'            => 'المحامين',
            'options'           => 'الخيارات',
            'cities'            => 'المدن',
            'clubs'             => 'النوادي',
            'organizer_mobile'  => 'موبيل المنظم',
            'club'              => 'النادي',
            'lawyer'            => 'المحام ',
            'user'              => 'المستخدم ',
            'organizer'         => 'منظم الحجز',
            'city'              => 'المدينه',
            'mobile'            => 'رقم الجوال',
            'lawyer_details'    => 'بيانات المحامي',
            'user_details'      => 'بيانات المستخدم',
            'name'              => 'الاسم',
            'reservation_date'  => 'تاريخ الحجز',
            'reservation_time'  => 'موعد الحجز',
            'service'           => 'الخدمة',
            'paid'       => [
                'title'  => 'حاله الدفع',
                'pending' => 'في انتظار الدفع',
                'failed' => 'فشل في الدفع',
                'paid'   => 'تم الدفع',
            ],
            'paid_by_admin' => 'مدفوع بواسطة اﻷدمن',
        ],
        'show' => [
            'tabs' => [
                'general'   => 'بيانات عامة',
            ],
            'times' => [
                'title' => 'مواعيد الحجز',
                'from'  => 'من ',
                'to'    => 'الي',
                'price' => 'السعر',
            ]
        ],
        'routes' => [
            'index' => ' الحجوزات ',
            'show' => ' عرض الحجز ',
        ],
    ],
    'reservations_calendar' => [
        'routes' => [
            'index' => ' تقويم  الحجوزات  ',
        ],
        'delete_btn' => 'هل تريد حذف الحجز؟',
        'form' => [
            'title'  => 'حجز جديد',
            'btn'    => 'حفظ',
            'name'   => 'اكتب الاسم',
            'mobile' => 'اكتب الموبيل',
        ],
        'select' => 'اختر',
    ],
];
