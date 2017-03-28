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
use app\admin\model\AdminLog;
use think\Controller;
use think\Exception;
use think\Request;
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

    /**
     * 保存更新后的数据
     * @return bool|\think\Response
     */
    public function updateAction()
    {
        $group_id = isset($_GET['group_id']) ? (int)$_GET['group_id'] : 0;
        $group_name = isset($_POST['group_name']) ? trim($_POST['group_name']) : '';
        $icon = isset($_POST['icon']) ? trim($_POST['icon']) : '';
        $group_permission = isset($_POST['group_permission']) ? trim($_POST['group_permission']) : '';
        if (empty($group_name)) {
            return \CommonBase::error('group_name_empty', '组名称不能为空');
        }
        if (empty($icon)) {
            return \CommonBase::error('icon_empty', '组图标不能为空');
        }
        if (empty($group_permission)) {
            return \CommonBase::error('group_permission_empty', '组权限不能为空');
        }

        if ($group_id > 0) {
            //更新
            $group = AdminGroup::get($group_id);
            if (!$group) {
                return \CommonBase::error('admin_group_not_found', '组不存在');
            }
            $group = $group->toArray();
            $old_group_name = $group['group_name'];
            $old_icon = $group['icon'];
            $old_group_permission = $group['group_permission'];
        } else {
            $old_group_name = '';
            $old_icon = '';
            $old_group_permission = '';
        }

        $old_group = AdminGroup::get(function($query) use ($group_id, $group_name){
            $query->where('group_name', $group_name);
            if ($group_id > 0) {
                $query->where('group_id', '<>', 'group_id');
            }
        });

        if ($old_group) {
            return \CommonBase::error('group_name_exist', '同名管理员组已存在');
        }
        $time = date('Y-m-d H:i:s');
        $new_params = [
            'group_name' => $group_name,
            'icon' => $icon,
            'group_permission' => $group_permission,
            'update_time' => $time
        ];

        try {
            if ($group_id > 0) {
                //更新
                $msg = '修改';
                AdminGroup::update($new_params, ['group_id' => $group_id]);
                $operation_short = 'edit admin group ' . $group_id;
                $operation_long = '编辑管理员组_旧数据组名' . $old_group_name . '_图标' .
                    $old_icon . '_权限' . $old_group_permission . '_新数据组名' . $group_name . '_图标' .
                    $icon . '_权限' . $group_permission;
            } else {
                //新增
                $msg = '新建';
                $new_params['create_time'] = $time;
                $data = AdminGroup::create($new_params);
                if ($data) {
                    $data = $data->toArray();
                } else {
                    return \CommonBase::error('add_error', '创建组失败');
                }
                $operation_short = 'add admin group ' . $data['group_id'];
                $operation_long = '增加管理员组_组名' . $group_name .
                    '_图标' . $icon . '_权限' . $group_permission;
            }

            //将操作写入日志
            AdminLog::create([
                'create_time' => $time,
                'admin_uid' => Session::get('admin_uid'),
                'ip' => Request::instance()->ip(),
                'operation_short' => $operation_short,
                'operation_long' => $operation_long
            ]);
            $this->success($msg . '成功！');
        } catch (Exception $e) {
            $this->error('操作失败');
        }
        return false;
    }
}
