<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/8/17
 * Time: 上午10:50
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\OperationT;
use app\api\validate\PagingParameter;
use app\api\service\Token as TokenService;
use app\lib\exception\OperationException;
use app\lib\exception\SuccessMessage;

class Operation extends BaseController
{

    /**
     * @return \think\response\Json
     * @throws OperationException
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    public function save()
    {
        (new PagingParameter())->goCheck();
        $c_id = TokenService::getCurrentTokenVar('c_id');
        $u_id = TokenService::getCurrentTokenVar('u_id');
        $grade = TokenService::getCurrentTokenVar('grade');
        $params = $this->request->param();
        $params['admin_id'] = $u_id;
        $params['c_id'] = $c_id;
        $params['type'] = $grade - 1;
        $params['count'] = $this->getCount($params['origin'], $grade);
        $o_id = OperationT::create($params);
        if (!$o_id) {
            throw new OperationException();
        }

        return json(new SuccessMessage());
    }

    /**
     * 录入/录出 数据转化为g
     * @param $origin
     * @param $grade
     * @return mixed
     */
    private function getCount($origin, $grade)
    {
        $density = config('setting.density');
        if ($grade == 2) {
            return $origin;
        }

        if ($grade == 3) {
            return $origin;
        }


    }

    /**
     * @param $page
     * @param $size
     * @return array|\think\response\Json
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    public function getOperations($page, $size)
    {
        (new PagingParameter())->goCheck();
        $c_id = TokenService::getCurrentTokenVar('c_id');
        $grade = TokenService::getCurrentTokenVar('grade');
        $list = OperationT::getOperations($page, $size, $c_id, $grade);
        return json($list);
    }
}


