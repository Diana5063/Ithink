<?php
/**
 * 管理员登录
 * Created by PhpStorm.
 * User: diana
 * Date: 17-1-16
 * Time: 下午11:26
 */

namespace app\admin\controller;

use think\Controller;
use think\Cookie;

class LoginController extends Controller
{
    public function indexAction()
    {
        Cookie::delete('admin_id');
        return $this->fetch('index');
    }

    public function doLoginAction()
    {
        $admin_id = (isset($_POST['admin_id']) && (int)$_POST['admin_id'] === 1) ? (int)$_POST['admin_id'] : 0;
        if ($admin_id === 1) {
            Cookie::set('admin_id', $admin_id);
            $this->redirect('/?s=admin/index');
        }
        $this->redirect('/?s=admin/login');
    }
}
