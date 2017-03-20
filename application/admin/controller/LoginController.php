<?php
/**
 * 管理员登录
 * Created by PhpStorm.
 * User: diana
 * Date: 17-1-16
 * Time: 下午11:26
 */

namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Cookie;
use think\Config;

class LoginController extends Controller
{
    public function indexAction()
    {
        Cookie::delete('admin_id');
        return $this->fetch('index');
    }

    public function doLoginAction()
    {
        //var_dump($_POST);exit;
        if (isset($_POST['username'])) {
            $username = trim($_POST['username']);
        } else {
            $username = '';
        }
        if (isset($_POST['password'])) {
            $password = trim($_POST['password']);
        } else {
            $password = '';
        }
        if (isset($_POST['captcha'])) {
            $captcha = trim($_POST['captcha']);
        } else {
            $captcha = '';
        }

        if ($admin_id === 1) {
            Cookie::set('admin_id', $admin_id);
            $this->redirect('/admin/index');
        }
        $this->redirect('/admin/login');
    }

    /**
     * 当前环境php安装信息
     * @return mixed
     */
    public function phpinfoAction()
    {
        echo phpinfo();
        return false;
    }
}
