<?php
/**
 * 后台首页
 * Created by PhpStorm.
 * User: diana
 * Date: 17-1-13
 * Time: 下午5:06
 */

namespace app\admin\controller;

use think\Controller;
use think\Session;

class IndexController extends Controller
{
    protected $beforeActionList = ['first'];//设置first方法为所有方法的前置方法

    /**
     * 检查管理员是否登录，没有登录时跳转到登录页
     */
    public function first()
    {
        $admin_uid = (int)Session::get('admin_uid');
        if ($admin_uid < 1) {
            //没有登录时返回登录页
            $this->redirect('/admin/login');
        }
    }

    /**
     * 后台首页
     * @return mixed
     */
    public function indexAction()
    {
        return $this->fetch('index', ['arr' => ['Yixin', 'Chen', 'Diana']]);
    }
}
