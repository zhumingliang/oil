<?php
/**
 * Created by PhpStorm.
 * User: mingliang
 * Date: 2018/8/16
 * Time: 下午4:16
 */

namespace app\api\model;


use think\Model;

class AdminComT extends Model
{
    public function com()
    {
        return $this->belongsTo('CompanyT',
            'com_id', 'id');
    }

}