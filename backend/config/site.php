<?php

return [
    'name' => 'Mile High Haul-Off',
    'phone' => '+1-720-999-0941',
    'phone_display' => '(720) 999-0941',
    'email' => 'milehighhauloff@gmail.com',
    'city' => 'Denver',
    'state' => 'CO',
    'address' => [
        'street' => '6699 West Mexico Place',
        'locality' => 'Lakewood',
        'region' => 'CO',
        'postal_code' => '80232',
    ],
    'hours' => [
        'Mon – Fri: 8 AM – 5 PM',
        'Sat: 10 AM – 3 PM',
    ],
    'service_areas' => [
        'Denver', 'Lakewood', 'Arvada', 'Wheat Ridge', 'Golden', 'Englewood',
        'Littleton', 'Centennial', 'Highlands Ranch', 'Evergreen', 'Aurora', 'Westminster',
    ],
    'gtag_id' => env('SITE_GTAG_ID', 'GT-MQB8X74N'),
];
