<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    //基础路由
    Route::get('/', 'IndexController@index');
    Route::post('login', 'PublicController@login');
    Route::any('logout', 'PublicController@login');
    Route::any('adminPassword', 'UserController@adminPassword');
    Route::any('profile', 'UserController@profile');
    Route::any('loginFrame', 'PublicController@loginFrame');
    Route::post('checkLogin', 'PublicController@checkLogin');
    Route::get('captcha', 'PublicController@captcha');
    Route::get('welcome', 'PublicController@welcome');
    Route::get('upload', 'PublicController@upload');

    //分组管理
    Route::get('group', 'GroupController@index');
    Route::any('group/forbid', 'GroupController@forbid');
    Route::any('group/resume', 'GroupController@resume');
    Route::any('group/recycle', 'GroupController@recycle');
    Route::any('group/add', 'GroupController@add');
    Route::any('group/edit', 'GroupController@edit');
    Route::any('group/sedit', 'GroupController@sedit');
    Route::any('group/delete', 'GroupController@delete');
    Route::any('group/sdelete', 'GroupController@sdelete');
    Route::any('group/saveOrder', 'GroupController@saveOrder');
    //角色管理
    Route::get('role', 'RoleController@index');
    Route::any('role/forbid', 'RoleController@forbid');
    Route::any('role/resume', 'RoleController@resume');
    Route::any('role/recycle', 'RoleController@recycle');
    Route::any('role/add', 'RoleController@add');
    Route::any('role/edit', 'RoleController@edit');
    Route::any('role/delete', 'RoleController@edit');
    Route::any('role/sedit', 'RoleController@sedit');
    Route::any('role/sdelete', 'RoleController@sdelete');
    Route::any('role/delete', 'RoleController@delete');
    Route::any('role/user', 'RoleController@user');
    Route::any('role/access', 'RoleController@access');

    //节点管理
    Route::any('node', 'NodeController@index');
    Route::any('node/forbid', 'NodeController@forbid');
    Route::any('node/resume', 'NodeController@resume');
    Route::any('node/recycle', 'NodeController@recycle');
    Route::any('node/add', 'NodeController@add');
    Route::any('node/edit', 'NodeController@edit');
    Route::any('node/sedit', 'NodeController@sedit');
    Route::any('node/delete', 'NodeController@delete');
    Route::any('node/sdelete', 'NodeController@sdelete');

    //管理员管理
    Route::get('user', 'UserController@index');
    Route::any('user/forbid', 'UserController@forbid');
    Route::any('user/resume', 'UserController@resume');
    Route::any('user/recycle', 'UserController@recycle');
    Route::any('user/add', 'UserController@add');
    Route::any('user/edit', 'UserController@edit');
    Route::any('user/delete', 'UserController@delete');
    Route::any('user/sedit', 'UserController@sedit');
    Route::any('user/sdelete', 'UserController@sdelete');
    Route::any('user/password', 'UserController@password');

    //文章管理
    Route::get('article', 'ArticleController@index');
    Route::any('article/forbid', 'ArticleController@forbid');
    Route::any('article/resume', 'ArticleController@resume');
    Route::any('article/recycle', 'ArticleController@recycle');
    Route::any('article/add', 'ArticleController@add');
    Route::any('article/edit', 'ArticleController@edit');
    Route::any('article/delete', 'ArticleController@delete');
    Route::any('article/sedit', 'ArticleController@sedit');
    Route::any('article/sdelete', 'ArticleController@sdelete');

    //文章分类管理
    Route::get('articleType', 'ArticleTypeController@index');
    Route::any('articleType/forbid', 'ArticleTypeController@forbid');
    Route::any('articleType/resume', 'ArticleTypeController@resume');
    Route::any('articleType/recycle', 'ArticleTypeController@recycle');
    Route::any('articleType/add', 'ArticleTypeController@add');
    Route::any('articleType/edit', 'ArticleTypeController@edit');
    Route::any('articleType/delete', 'ArticleTypeController@delete');
    Route::any('articleType/sedit', 'ArticleTypeController@sedit');
    Route::any('articleType/sdelete', 'ArticleTypeController@sdelete');

    //登录日志管理
    Route::get('loginLog', 'LoginLogController@index');
});