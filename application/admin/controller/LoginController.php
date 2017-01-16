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

class LoginController extends Controller
{
    public function indexAction()
    {
        setcookie('admin_id', 1, -1, '/', 'yixin.dev.com');
        return $this->fetch('index');
    }

    public function doLoginAction()
    {
        $admin_id = (isset($_POST['admin_id']) && (int)$_POST['admin_id'] === 1) ? (int)$_POST['admin_id'] : 0;
        if ($admin_id === 1) {
            setcookie('admin_id', $admin_id, time() + 3600, '/', 'yixin.dev.com');
            $this->redirect('/?s=admin/index');
        }
        $this->redirect('/?s=admin/login');
    }
}
