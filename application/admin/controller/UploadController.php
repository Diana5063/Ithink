<?php
/**
 * 图片上传
 * Created by PhpStorm.
 * User: diana
 * Date: 17-3-27
 * Time: 上午9:25
 */

namespace app\admin\controller;

use think\Controller;

class UploadController extends Controller
{
    public function indexAction()
    {
        $file = request()->file('image');
        // 移动到框架应用根目录/public/upload/ 目录下
        $info = $file->move(\CommonBase::getUploadPath());
        if ($info) {
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename();
            return json_encode(['file_path' => $info->getSaveName()]);
        } else {
            // 上传失败获取错误信息
            echo $file->getError();
        }
        return false;
    }
}
