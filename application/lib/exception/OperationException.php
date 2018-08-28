<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/5/22
 * Time: 16:56
 */

namespace app\lib\exception;


class OperationException extends BaseException
{
    public $code = 401;
    public $msg = '新增操作记录失败';
    public $errorCode = 20001;
}