<?php

return [
    'courses' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'type' => 'type',
            'categories' => 'categories',
        ],
         'days'  =>  [
                'sat'   =>  'Saturday',
                'sun'   =>  'Sunday',
                'mon'   =>  'Monday',
                'tue'   =>  'Tuesday',
                'wed'   =>  'Wednesday',
                'thu'   =>  'Thursday',
                'fri'   =>  'Friday',
            ],
        'form' => [
            'address' => 'Address of classes',
            'description' => 'Description',
            'image' => 'Image',
            'target' => 'target',
            'class_time' => 'class time',
            'intro_video' => 'Intro Video',
            'is_certificated' => 'Is Certificated',
            'is_published' => 'Published',
            'lang' => 'longitude',
            'lat' => 'latitude',
            'level' => 'level',
            'map' => 'Map Embed iframe',
            'price' => 'Price',
            'requirements' => 'Requirements',
            'restore' => 'Restore from trash',
            'status' => 'Status',
            'start_date' => 'start date',
            'end_date'   => 'end date',
            'tabs' => [
                'categories' => 'Categories',
                'gallery' => 'Gallery',
                'general' => 'General Info.',
                'targets' => 'targets',
                'schedule'=>'Course schedule'


            ],
            'available_days'=>'available days',
            'time'=>'time',
            'duration'=>'duration',
            'is_live'=>'live',
            'course_start_date'=>'Course Start Date',
            'genderTypes' => [
                'male' => 'male',
                'female' => 'female',
            ],
            'genderType' => 'gender type',
            'title' => 'Title',
            'instructors' => 'Instructors',
            'type' => 'In footer',
            'period' => 'Period (days number)',
            'short_desc' => ' short description',
        ],
        'routes' => [
            'create' => 'Create Courses',
            'index' => 'Courses',
            'update' => 'Update Course',
        ],

    ],

      'coursereviews' => [
        'datatable' => [
            'created_at' => 'created_at',
            'date_range' => 'date_range',
            'options'    => 'options',
            'status'     => 'status',
            'course'     => 'course',
            'user'       => 'user',
              'stars'      => 'stars',
        ],

        'form' => [
            'status' => 'status',
            'in_slider' => 'in slider',
              'desc'  => 'desc ',
            'stars' => 'stars',
             'tabs' => [
                'general' => 'General Info.',
            ],
        ],
        'routes' => [
            'index'  => 'courses reviews',
            'update' => 'edit courses reviews',
        ],

    ],
    'lessons' => [
        'datatable' => [
            'course' => 'Course',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
        ],
        'form' => [
            'address' => 'Address of classes',
            'courses' => 'Course',
            'image' => 'Image',
            'restore' => 'Restore from trash',
            'status' => 'Status',
            'video' => 'video',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
        ],
        'routes' => [
            'create' => 'Create Courses Lessons',
            'index' => 'Courses Lessons',
            'update' => 'Update Course Lesson',
        ],

    ],
    'videos' => [
        'video_status' => 'Video Status',
        'title' => 'Title',
        'loaded' => 'Loaded',
        'loading' => 'Loading',
        'failed' => 'Failed',
        'not_found' => 'Not Found',
    ],
    'lessoncontents' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'video_status' => 'Video Status',
            'title' => 'Title',
            'loaded' => 'Loaded',
            'loading' => 'Loading',
            'failed' => 'Failed',
            'not_found' => 'Not Found',
        ],
        'form' => [
            'address' => 'Address of classes',
            'description' => 'Description',
            'image' => 'Image',
            'is_certificated' => 'Is Certificated',
            'is_published' => 'Published',
            'restore' => 'Restore from trash',
            'start_date' => 'Start date',
            'start_time' => 'Start time',
            'status' => 'Status',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
            'trainers' => 'Trainers',
            'type' => 'type of content',
            'order' => 'order',
            'types' => [
                'resource' => 'file',
                'exam' => 'exam',
                'video' => 'video',
            ],
            'lessons' => 'lessons',

        ],
        'routes' => [
            'create' => 'Create Lesson Videos',
            'index' => 'Lesson Videos',
            'update' => 'Update Lesson Videos',
        ],

    ],
    'levels' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'title' => 'Title',
            'desc' => 'description',
            'short_desc' => 'short description',
            'loading' => 'Loading',
            'failed' => 'Failed',
            'not_found' => 'Not Found',
        ],
        'form' => [
            'desc' => 'Description',
            'short_desc' => 'Short Description',
            'image' => 'Image',
            'pdf' => 'pdf file',
            'restore' => 'Restore from trash',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
            'start_exam' => 'start level exam',
            'end_exam' => 'end level exam',
            'price' => 'السعر',
            'paid' => 'paid',
            'required_start_exam' => 'required start exam',
            'required_end_exam' => 'required end exam',
            'pdf' => ' pdf file',
            'restore' => 'restore',
            'status' => 'status',

            'requirements' => 'requirements',
        ],
        'routes' => [
            'create' => 'Create level',
            'index' => 'levels',
            'update' => 'Update level',
        ],
    ],
];
