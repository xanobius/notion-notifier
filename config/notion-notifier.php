<?php

return [
    'secret' => env('NOTION_SECRET', ''),
    'page_id' => env('NOTION_PAGE_ID', ''),
    'patch' => [
        'framework' => [
            'active' => true,
            'property' => env('NOTION_LARAVEL_PROP', ''),
        ],
        'git' => [
            'active' => true,
            'property' => env('NOTION_GIT_PROP', ''),
            'last_proper' => false
        ]

    ]
];