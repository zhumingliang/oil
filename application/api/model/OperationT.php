<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/8/17
 * Time: 上午12:02
 */

namespace app\api\model;


use app\api\service\Admin;
use think\Model;

class OperationT extends Model
{
    protected $createTime = 'create_time';
    protected $updateTime = 'last_update';

    //关联商品名称
    public function goods()
    {
        return $this->belongsTo('GoodsT',
            'g_id', 'id');
    }


    public function getRemarkAttr($value)
    {

        if (!strlen($value))
        {
            return '无';
        }
        return $value;
    }

    public function getTypeAttr($key)
    {

        $value=[1=>'录入',2=>'录出'];
        return $value[$key];
    }

    //关联操作员名称
    public function admin()
    {
        return $this->belongsTo('AdminT',
            'admin_id', 'id');
    }

    /**
     * @param $page
     * @param $size
     * @param $c_id
     * @param $grade
     * @return \think\Paginator
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getOperations($page, $size, $c_id, $grade)
    {
        $c_ids=Admin::getSonID();
        $list = self::where('c_id', 'in', $c_ids)
            ->with('goods,admin')
            ->where(function ($query) use ($grade) {
                if ($grade >= 2) {
                    $query->where('type', '=', $grade - 1);
                }

            })
            ->order('create_time desc')
            ->paginate($size, false, ['page' => $page]);
        return $list;

    }

}