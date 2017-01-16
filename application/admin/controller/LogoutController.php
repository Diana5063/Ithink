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

class LogoutController extends Controller
{
    public function indexAction()
    {
        setcookie('admin_id', 1, -1, '/', 'yixin.dev.com');
        $this->redirect('/?s=admin/login');
    }
}
