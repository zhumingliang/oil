<?php
/**
 * Created by PhpStorm.
 * User: zhumingliang
 * Date: 2018/3/20
 * Time: 下午2:00
 */

namespace app\api\validate;


class Operation extends BaseValidate
{
    protected $rule = [
        'origin' => 'require',
        'g_id' => 'require'
    ];

    protected $message = [
        'origin' => '新增操作记录必须录入原始数据',
        'g_id' => '新增操作记录必须录入商品id'
    ];

}