<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/8/27
 * Time: 上午9:59
 */

namespace app\api\service;


use app\api\model\AdminT;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;

class Admin
{
    /**
     * 获取管理员下子管理员
     * @return string
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getSonID()
    {
        if (Token::getCurrentTokenVar('grade') > 1) {
            return Token::getCurrentTokenVar('c_id');
        }

        $admins = AdminT::getSonID();
        $com_arr = array();
        if ($admins->isEmpty()) {
            return '';
        } else {

            foreach ($admins as $k => $v) {
                if (!is_null($v->ac)) {
                    array_push($com_arr, $v->ac->com_id);
                }
            }
        }
        $id_arr = implode(',', array_unique($com_arr));
        return $id_arr;
    }


    /**
     * 修改密码
     * @param $old
     * @param $new
     * @return SuccessMessage
     * @throws TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function updatePasswd($old, $new)
    {
        $u_id = Token::getCurrentUid();
        $admin = AdminT::where('id', '=', $u_id)
            ->find();
        if (sha1($old) != $admin->pwd) {
            throw new TokenException([
                'msg' => '旧密码不正确，请重新输入',
                'errorCode' => 20003
            ]);
        }
        $res = $admin->allowField(true)
            ->save(['pwd' => sha1($new)], ['id' => $u_id]);
        if (!$res) {
            throw new TokenException([
                'msg' => '修改密码失败',
                'errorCode' => 20004
            ]);
        }

        return new SuccessMessage();

    }

}