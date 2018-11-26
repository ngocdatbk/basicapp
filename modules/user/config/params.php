<?php

return [
    //Set default profile picture
    'avatar' => [
        'Female' => 'no-avatar-female.png',
        'Male' => 'no-avatar-male.png',
        'Default' => 'user-small-icon_100_100.png',
    ],
    'active_status' => [
        0 => 'Không hoạt động',
        1 => 'Hoạt động'
    ],
    'not_login_days' => 7,
    'number_login_attempt' => 5,
    'time_retry_login' => 1800, //Sec
];
