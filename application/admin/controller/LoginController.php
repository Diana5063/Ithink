<?php
/**
 * 管理员登录
 * Created by PhpStorm.
 * User: diana
 * Date: 17-1-16
 * Time: 下午11:26
 */

namespace app\admin\controller;

use app\admin\model\AdminInfo;
use app\admin\model\AdminLog;
use think\Controller;
use think\Request;
use think\Session;

class LoginController extends Controller
{
    /**
     * 登录页
     * @return mixed
     */
    public function indexAction()
    {
        if (Session::get('admin_uid') && (int)Session::get('admin_uid') > 0) {
            $this->redirect('/admin/index');
        }
        return $this->fetch('index');
    }

    /**
     * 登录操作
     */
    public function doLoginAction()
    {
        if (isset($_POST['nick_name'])) {
            $nickname = trim($_POST['nick_name']);
        } else {
            $nickname = '';
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

        //检查验证码
        if (!captcha_check($captcha)) {
            //验证码错误
            return \CommonBase::error('captcha_error', '验证码错误');
        }

        $admin = AdminInfo::get(['nick_name' => $nickname]);
        if (!$admin) {
            return \CommonBase::error('admin_not_found', '账号不存在');
        }
        $admin = $admin->toArray();

        //验证密码
        $login_password = \CommonBase::encryptPassword($password, $admin['salt']);
        if ($login_password !== $admin['password']) {
            return \CommonBase::error('password_error', '密码错误');
        }

        $time = date('Y-m-d H:i:s');//当前服务器时间
        //登录成功后更新最后登录时间
        AdminInfo::update(['last_login_time' => $time], ['admin_uid' => $admin['admin_uid']]);

        //将登录操作写入日志
        AdminLog::create([
            'create_time' => $time,
            'admin_uid' => $admin['admin_uid'],
            'ip' => Request::instance()->ip(),
            'operation_short' => 'login',
            'operation_long' => '登录'
        ]);

        //登录信息存入session
        Session::set('admin_uid', $admin['admin_uid']);
        Session::set('nick_name', $admin['nick_name']);

        $this->redirect('/admin/index');
        return false;
    }

    /**
     * 退出登录
     * @return mixed
     */
    public function logoutAction()
    {
        //清除登录信息并退出到登录页面
        Session::clear('yx_adm_');
        return $this->fetch('/login/index');
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
