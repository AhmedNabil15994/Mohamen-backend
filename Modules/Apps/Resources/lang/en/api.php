<?php

return [
    'apps' => [
        'validations' => [
            'page' =>[
                'required' => 'Please send the page number',
                'min' => 'Page number should be greater than or equal 1',
                'numeric' => 'Page number should be numeric',
            ]
        ]
    ],
    'messages'  => [
        'created'       => 'Created Successfully',
        'delete'        => 'Do you need to delete the recored ?',
        'delete_all'    => 'Do you need to delete this selected recored ?',
        'deleted'       => 'Deleted Successfully',
        'failed'        => 'Something error! , try again',
        'updated'       => 'Updated Successfully',
        'success'       => 'Successfully',
        'duplicated_order'       => 'you have order this before',
    ],
    'contact_us' => [
        'mail' => [
            'subject' => 'Contact us message',
            'contact-us' => 'Contact us',
        ],
        'validations' => [
            'username' => [
                'required' => 'Name is required',
                'string' => 'Name should be characters only',
            ],
            'mobile' => [
                'required' => 'Mobile is required',
            ],
            'message' => [
                'required' => 'Message is required',
                'min' => 'Message is min in 10 characters',
            ]
        ]
    ]
];
