<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/8/16
 * Time: 下午4:08
 */

namespace app\api\model;


use app\api\service\Admin;
use app\api\service\AdminToken;
use app\api\service\Token;
use think\Model;

class GoodsT extends Model
{

    public function operation()
    {
        return $this->hasMany('OperationT',
            'g_id', 'id');
    }

    public static function getList($page, $size)
    {


        $c_ids=Admin::getSonID();
        $list = self::where('c_id', 'in', $c_ids)
            ->with('operation')
            ->paginate($size, false, ['page' => $page])->toArray();

        $data = self::prefixGoods($list['data']);
        $list['data'] = $data;
        return $list;

    }

    private static function prefixGoods($list)
    {
        if (count($list)) {
            foreach ($list as $k => $v) {
                $operation = $list[$k]['operation'];
                $balance = 0;
                if (count($operation)) {
                    foreach ($operation as $k2 => $v2) {
                        if ($v2['type'] == '录入') {
                            $balance += $v2['count'];
                        } else if ($v2['type'] == '录出') {
                            $balance -= $v2['count'];
                        }

                    }

                }
                $list[$k]['balance'] = $balance;
                unset($list[$k]['operation']);
            }

        }

        return $list;

    }


}