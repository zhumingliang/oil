<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/8/16
 * Time: 下午3:47
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\GoodsT;
use app\api\validate\PagingParameter;
use app\api\service\Token as TokenService;
use think\Exception;

class Goods extends BaseController
{
    /**
     * @param $page
     * @param $size
     * @return \think\response\Json
     * @throws \app\lib\exception\ParameterException
     * @throws \think\Exception
     */
    public function goodsList($page, $size)
    {
        (new PagingParameter())->goCheck();
        //$grade = TokenService::getCurrentTokenVar('grade');
        $list = GoodsT::getList($page, $size);
        return json($list);

    }

}