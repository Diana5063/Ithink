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
use think\Session;

class LogoutController extends Controller
{
    public function indexAction()
    {
        //清除登录信息并退出到登录页面
        Session::clear('yx_adm_');
        $this->redirect('/admin/login');
    }
}
