<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/5/27
 * Time: 下午4:06
 */

namespace app\api\model;


use app\api\service\Token;
use think\Model;

class AdminT extends Model
{

    public function ac()
    {
        return $this->hasOne('AdminComT',
            'admin_id', 'id');
    }


    public static function getAdminForLogin($phone)
    {

        $admin = self::with(['ac' => function ($query) {
            $query->where('state', '=', 1)
                ->with(['com' => function ($query1) {
                    $query1->where('state', '=', 1);
                }]);
        }])
            ->where('phone', '=', $phone)
            ->find();

        return $admin;
    }

    /**
     * 获取管理员下子管理员
     * @return array|string
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getSonID()
    {
        $u_id = Token::getCurrentTokenVar('u_id');
        $admins = self::where('parent', '=', $u_id)
            ->where('state', '=', 1)
            ->with(['ac' => function ($query) {
                $query->where('state', '=', 1);
            }])
            ->select();
        return $admins;
    }


}