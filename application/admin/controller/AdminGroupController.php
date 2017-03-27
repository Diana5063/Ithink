<?php
/**
 * 管理员组
 * Created by PhpStorm.
 * User: diana
 * Date: 17-3-24
 * Time: 下午2:47
 */

namespace app\admin\controller;

use app\admin\model\AdminGroup;
use think\Controller;
use think\Session;

class AdminGroupController extends Controller
{
    /**
     * 设置first方法为所有方法的前置方法
     * @var array
     */
    protected $beforeActionList = ['first'];

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
     * 管理员组列表
     *
     * 功能要求：分页、组名关键字搜索
     *
     * 参数：
     * rpp |int |每页数量
     * group_name |string |组名关键字
     *
     * @return mixed
     */
    public function indexAction()
    {
        $rpp = isset($_POST['rpp']) ? (int)$_POST['rpp'] : 10;//每页数量，默认为10条
        $order = ['group_id' => 'desc'];
        $where = [];
        if (isset($_POST['group_name']) && trim($_POST['group_name']) !== '') {
            $where['group_name like ?'] = '%' . trim($_POST['group_name']) . '%';
        }

        $total_num = AdminGroup::where($where)->count('*');
        $group_list = AdminGroup::where($where)->order($order)->paginate($rpp, $total_num);
        return $this->fetch('index', [
            'group_list' => $group_list->toArray(),
            'paginator' => $group_list->render()
        ]);
    }

    /**
     * 获取管理员信息并显示到编辑模板上
     * @return mixed|\think\Response
     */
    public function editAction()
    {
        $group_id = isset($_GET['group_id']) ? (int)$_GET['group_id'] : 0;
        if ($group_id > 0) {
            //更新
            $group_info = AdminGroup::get($group_id);
            if (!$group_info) {
                return \CommonBase::error('group_not_found', '管理员组不存在');
            }
            $group_info = $group_info->toArray();
        } else {
            $group_info = [];
        }
        return $this->fetch('edit', ['group_info' => $group_info]);
    }

    public function updateAction()
    {
        return false;
    }
}
