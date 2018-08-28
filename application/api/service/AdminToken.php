<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/5/19
 * Time: 18:27
 */

namespace app\api\service;


use app\api\model\AdminT;
use app\lib\enum\UserEnum;
use app\lib\exception\TokenException;
use think\Exception;
use think\facade\Cache;

class AdminToken extends Token
{
    protected $phone;
    protected $pwd;


    function __construct($phone, $pwd)
    {
        $this->phone = $phone;
        $this->pwd = $pwd;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        try {


            $admin = AdminT::getAdminForLogin($this->phone);

            if (is_null($admin)) {
                throw new TokenException([
                    'code' => 404,
                    'msg' => '用户不存在',
                    'errorCode' => 30000
                ]);
            }

            if ($admin->state != UserEnum::USER_STATE_OK) {
                throw new TokenException([
                    'code' => 401,
                    'msg' => '该用户已停用',
                    'errorCode' => 30003
                ]);

            }


            if (($admin->grade > 1)) {
                if (is_null($admin->ac)) {
                    throw new TokenException([
                        'code' => 401,
                        'msg' => '该账号未分配公司，请联系管理员',
                        'errorCode' => 30004
                    ]);

                }


                if (is_null($admin->ac->com)) {
                    throw new TokenException([
                        'code' => 401,
                        'msg' => '该公司已经停用，请联系管理员',
                        'errorCode' => 30005
                    ]);
                }

            }

            if (sha1($this->pwd) != $admin->pwd) {
                throw new TokenException([
                    'code' => 401,
                    'msg' => '密码不正确',
                    'errorCode' => 30002
                ]);
            }


            /**
             * 获取缓存参数
             */
            $cachedValue = $this->prepareCachedValue($admin);
            /**
             * 缓存数据
             */
            $token = $this->saveToCache('', $cachedValue);
            return $token;

        } catch (Exception $e) {
            throw $e;
        }

    }



    /**
     * @param $key
     * @param $cachedValue
     * @return mixed
     * @throws TokenException
     */
    private function saveToCache($key, $cachedValue)
    {
        $key = empty($key) ? self::generateToken() : $key;
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $request = Cache::remember($key, $value, $expire_in);


        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 20002
            ]);
        }

        $cachedValue['token'] = $key;
        return $cachedValue;
    }

    private function prepareCachedValue($admin)
    {

        $cachedValue = [
            'u_id' => $admin->id,
            'phone' => $admin->phone,
            'username' => $admin->username,
            'grade' => $admin->grade,
            'c_id' => $admin->grade == 1 ? 0 : $admin->ac->com_id,
        ];

        return $cachedValue;
    }




}