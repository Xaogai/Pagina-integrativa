<?php

return [
    'admin' => [
        'type' => 1,
        'children' => [
            'manageUsers',
        ],
    ],
    'manageUsers' => [
        'type' => 2,
        'description' => 'Gestionar usuarios',
    ],
];
