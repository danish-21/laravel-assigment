<?php

use App\Models\File;

return [
    'is_local' => true,
    'types' => [
        File::TYPE_BLOG_IMAGE => [
            'type' => File::TYPE_BLOG_IMAGE,
            'local_path' => 'images/blog',
            'validation' => 'required',
            'valid_file_types' => ['jpg', 'png', 'jpeg'],
        ],
        File::TYPE_PROFILE_IMAGE => [
            'type' => File::TYPE_PROFILE_IMAGE,
            'local_path' => 'images/profile',
            'validation' => 'required',
            'valid_file_types' => ['jpg', 'png', 'jpeg'],
        ],
    ]
];
