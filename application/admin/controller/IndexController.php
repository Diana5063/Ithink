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
use think\Cookie;

class IndexController extends Controller
{
    public function indexAction()
    {
        $admin_id = (int)Cookie::get('admin_id');
        if ($admin_id !== 1) {
            $this->redirect('/admin/login');
        }
        return $this->fetch('index', ['arr' => ['Yixin', 'Chen', 'Diana']]);
    }
}
