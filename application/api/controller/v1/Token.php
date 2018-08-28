<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/5/27
 * Time: 上午9:53
 */

namespace app\api\controller\v1;


use app\api\model\AdminT;
use app\api\model\TestT;
use app\api\service\Admin;
use app\api\service\AdminToken;
use app\api\service\UserInfoService;
use app\api\service\WxTemplate;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use think\Controller;
use think\facade\Cache;
use app\api\validate\User as userValidate;
use app\api\service\Token as tokenService;
use think\facade\Session;


class Token extends Controller
{

    /**
     * @param $phone
     * @param $pwd
     * @return \think\response\Json
     * @throws \app\lib\exception\ParameterException
     * @throws \think\Exception
     */
    public function getAdminToken($phone, $pwd)
    {
        (new TokenGet())->goCheck();
        $at = new AdminToken($phone, $pwd);
        $token = $at->get();
        return json($token);
    }


    /**
     * @param string $token
     * @return array
     * @throws ParameterException
     */
    public function verifyToken($token = '')
    {
        if (!$token) {
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }

    /**
     * @return \think\response\Json
     */
    public function loginOut()
    {
        $token = \think\facade\Request::header('token');
        Cache::rm($token);
        return json(new SuccessMessage());
    }

    /**
     * @param string $old
     * @param string $new
     * @return \think\response\Json
     * @throws TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function updatePasswd($old = '', $new = '')
    {
        $res = Admin::updatePasswd($old, $new);
        return json($res);


    }

}