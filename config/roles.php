<?php

// The default permissions and roles of the system
return [
    'role' => [
        'superAdmin' => ['name' => '超级管理员', 'guard_name' => 'admin'],
    ],
    'permission' => [
        // 如果新增的路由则需要在这里补充并且利用需要保存到数据库中
        '管理员模块' => [
            ['name' => '添加管理员', 'guard_name' => 'admin', 'route' => 'admins.store'],
            ['name' => '修改管理员', 'guard_name' => 'admin', 'route' => 'admins.update'],
            ['name' => '删除管理员', 'guard_name' => 'admin', 'route' => 'admins.destroy'],
        ],
        '分类模块' => [
            ['name' => '添加分类', 'guard_name' => 'admin', 'route' => 'categories.store'],
            ['name' => '修改分类', 'guard_name' => 'admin', 'route' => 'categories.update'],
            ['name' => '删除分类', 'guard_name' => 'admin', 'route' => 'categories.destroy'],
        ],
        '商品管理' => [
            ['name' => '添加商品', 'guard_name' => 'admin', 'route' => 'products.store'],
            ['name' => '修改商品', 'guard_name' => 'admin', 'route' => 'products.update'],
            ['name' => '删除商品', 'guard_name' => 'admin', 'route' => 'products.destroy'],
        ],
        '会员模块' => [
            ['name' => '添加用户', 'guard_name' => 'admin', 'route' => 'users.store'],
            ['name' => '修改用户', 'guard_name' => 'admin', 'route' => 'users.update'],
            ['name' => '删除用户', 'guard_name' => 'admin', 'route' => 'users.destroy'],
        ]
    ]
];
