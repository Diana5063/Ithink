<?php
/**
 * 管理员退出登录
 * Created by PhpStorm.
 * User: diana
 * Date: 17-1-16
 * Time: 下午11:27
 */

namespace app\admin\controller;


use think\Controller;
use think\Cookie;

class LogoutController extends Controller
{
    public function indexAction()
    {
        Cookie::delete('admin_id');//退出时删除当前cookie
        $this->redirect('/?s=admin/login');
    }
}
