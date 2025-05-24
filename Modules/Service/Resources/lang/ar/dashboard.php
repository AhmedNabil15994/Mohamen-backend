<?php

return [
    'services' => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'العنوان',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'description'       => 'الوصف',
            'image'             => 'الصورة',
            'status'            => 'الحالة',
            'type'            => ' نوع الخدمه',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان الخدمات',
            'types' => [
                'chat' => 'رسائل نصيه',
                'video' => 'مكالمه فيديو',
                'call' => 'مكالمه صوتيه',
            ],

        ],
        'routes'    => [
            'create'    => 'اضافة الخدمات',
            'index'     => 'الخدمات',
            'update'    => 'تعديل الخدمات',
        ],
    ],
];
