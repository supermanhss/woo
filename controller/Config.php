<?php

return [
    'dsn' => 'mysql:host=localhost;dbname=woo',
    'db_username' => 'root',
    'db_password' => 'root',
    'controller' => [
        [
            'command' => 'Default',
            'view' => 'main'
        ],
        [
            'command' => 'Default',
            'status' => 'CMD_OK',
            'view' => 'main'
        ],
        [
            'command' => 'Default',
            'status' => 'CMD_ERROR',
            'view' => 'error'
        ],
        [
            'command' => 'ListVenues',
            'view' => 'list_venues',
        ],
        [
            'command' => 'QuickAddVenue',
            'view' => 'quick_add',
            'classRoot' => 'AddVenue'
        ],
        [
            'command' => 'AddVenue',
            'view' => 'add_venue',
            'forward' => [
                'status' => 'CMD_OK',
                'newCommand' => 'AddSpace'
            ]
        ],
        [
            'command' => 'AddSpace',
            'view' => 'add_space',
            'forward' => [
                'status' => 'CMD_OK',
                'newCommand' => 'ListVenues'
            ]
        ],
    ]
];