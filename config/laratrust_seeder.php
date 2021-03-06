<?php

return [
    'role_structure' => [
        'administrator' => [
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'top-manager' => [
            'profile' => 'r,u'
        ],
        'manager' => [
            'profile' => 'r,u'
        ],
        'teacher' => [
            'profile' => 'r,u'
        ],
        'student' => [
            'profile' => 'r,u'
        ],
        'owner' => [
            'profile' => 'r,u'
        ],
    ],
    'permission_structure' => [
      []
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
