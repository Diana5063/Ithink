<?php
/**
 * 用户首页
 * Created by PhpStorm.
 * User: diana
 * Date: 17-1-13
 * Time: 下午5:07
 */

namespace app\user\controller;

class IndexController
{
    public function indexAction()
    {
        return 'User index';
    }

    public function loginAction()
    {
        return 'User login';
    }

    public function logoutAction()
    {
        return 'User logout';
    }
}
