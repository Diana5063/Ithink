<?php
/**
 * 公共方法
 * Created by PhpStorm.
 * User: diana
 * Date: 17-3-23
 * Time: 下午3:26
 */

use think\Response;

class CommonBase
{
    /**
     * 提示错误信息
     * @param string $id
     * @param string $msg
     * @return Response
     */
    public static function error($id = '', $msg = '')
    {
        $reponse = new Response();
        $reponse->code(422);
        $str = '{"error":{"id":"' . $id . '", "message":"'. $msg . '"}}';
        $reponse->content($str);
        return $reponse;
    }

    /**
     * 密码加密
     * @param $password
     * @param $salt
     * @return string
     */
    public static function encryptPassword($password, $salt)
    {
        return md5(md5($password) . $salt);
    }

    public static function genSalt($length = 6)
    {
        $str = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        for($i = 0; $i < $length; $i++) {
            $str .= $strPol[mt_rand(0, mb_strlen($strPol) - 1)];
        }
        return $str;
    }
}
