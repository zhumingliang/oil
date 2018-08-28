<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');
Route::get('api/:version/index', 'api/:version.Index/index');
Route::get('api/:version/token/out', 'api/:version.Token/loginOut');
Route::post('api/:version/token/admin', 'api/:version.Token/getAdminToken');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');
Route::post('api/:version/admin/update', 'api/:version.Token/updatePasswd');

Route::get('api/:version/goods/list', 'api/:version.Goods/goodsList');
Route::get('api/:version/goods', 'api/:version.Goods/goods');


Route::post('api/:version/operation/save', 'api/:version.Operation/save');
Route::get('api/:version/operation/operations', 'api/:version.Operation/getOperations');



return [

];
