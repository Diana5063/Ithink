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

class IndexController extends Controller
{
    public function indexAction()
    {
        if (!isset($_COOKIE['admin_id']) || (int)$_COOKIE['admin_id'] !== 1) {
            $this->redirect('/?s=admin/login');
        }
        return $this->fetch('index', ['arr' => ['Yixin', 'Chen', 'Diana']]);
    }
}
