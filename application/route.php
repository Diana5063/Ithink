<?php
// +----------------------------------------------------------------------
// | Author: Dianachen <cyxl510@126.com>
// +----------------------------------------------------------------------

return [
    //管理员模块路由
    'phpinfo' => 'admin/Login/phpInfo',
    'upload' => 'admin/Upload/index',
    'admin/login' => ['admin/Login/index', ['method' => 'post']],
    'admin/doLogin' => ['admin/Login/doLogin', ['method' => 'post']],
    'admin/logout' => 'admin/Logout/index',
    'admin/index' => ['admin/Index/index', []],
    'admin/group' => 'admin/AdminGroup/index',
    'admin/group/:group_id' => ['admin/AdminGroup/edit', ['method' => 'post|get'], ['group_id' => '\d+']],
    'admin/group/update' => ['admin/AdminGroup/update', ['method' => 'post']],


    //index模块路由
    '' => 'index/Index/index',

    //用户模块路由
    'login' => ['user/Login/index', ['method' => 'post']],
    'user/index' => ['user/Index/index', []]
];
