<?php

return [
    [
        'type' => 'link',
        'title' => 'Dashboard',
        'icon' => 'fa-solid fa-house',
        'route' => 'admin.dashboard',
        'active' => 'admin.dashboard',
    ],

      [
        'type' => 'header',
        'title' => 'Administración',
         'can' => ['read_users', 'update_users', 'delete_users','read_roles', 'create_roles', 'delete_roles']
    ],

     [
        'type' => 'link',
        'title' => 'Usuarios',
        'icon' => 'fa fa-users',
        'route' => 'admin.users.index',
        'active' => 'admin.users.*',
        'can' => ['read_users', 'update_users', 'delete_users'],
    ],
   

      [
        'type' => 'link',
        'title' => 'Roles',
        'icon' => 'fa fa-shield',
        'route' => 'admin.roles.index',
        'active' => 'admin.roles.*',
        'can' => ['read_roles', 'create_roles', 'delete_roles'],
    ],
];
