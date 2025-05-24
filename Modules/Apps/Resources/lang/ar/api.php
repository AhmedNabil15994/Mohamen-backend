<?php

return [
    'apps' => [
        'validations' => [
            'page' =>[
                'required' => 'رقم  الصفحة مطلوب',
                'min' => 'رقم الصفحة يجب ان يكون اكبر من او يساوي 1',
                'numeric' => 'رقم الصفحة يجب ان يكون رقم',
            ]
        ]
    ],
    'messages'  => [
        'created'       => 'تم الاضافة بنجاح',
        'delete'        => 'هل تريد حذف هذا الحقل ؟',
        'delete_all'    => 'هل تريد حذف هذة الحقول المحدده ؟',
        'deleted'       => 'تم الحذف بنجاح',
        'failed'        => 'حدث خطا ما ! ، حاول مرة اخرى',
        'updated'       => 'تم التعديل بنجاح',
        'success'       => 'تمت العملية بنجاح',
        'duplicated_order'       => 'تم الشراء من قبل   ',
    ],
    'contact_us' => [
        'mail' => [
            'subject' => 'Contact us message',
            'contact-us' => 'تواصل معنا',
        ],
        'validations' => [
            'username' => [
                'required' => 'الاسم مطلوب',
                'string' => 'الاسم يجب ان يكون حروف فقط',
            ],
            'mobile' => [
                'required' => 'رقم الهاتف مطلوب',
            ],
            'message' => [
                'required' => 'الرسالة مطلوبة',
                'min' => 'يججب ان لا تقل الرساله عن 10 احرف ',
            ],
        ]
    ]
];
