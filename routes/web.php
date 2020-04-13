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

Route::get('/', function () {
    return view('welcome');
});

	Route::get('/home/index/index','Home\IndexController@index');

	Route::get('admin/login/index','Admin\LoginController@index');

	Route::post('admin/login/login','Admin\LoginController@login');

	Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function(){

	Route::get('index/index','IndexController@index');

	Route::get('login/logout','LoginController@logout');

	Route::get('user/index','UserController@index');

	Route::get('user/add','UserController@create');

	Route::post('user/doAdd','UserController@doAdd');

	Route::get('user/edit/{id}','UserController@edit');

	Route::post('user/update/{id}','UserController@update');

	Route::post('user/del/{id}','UserController@del');

	Route::post('user/status','UserController@status');

	Route::post('user/delAll','UserController@delAll');

	// 角色与权限
	Route::get('admin/index','AdminUserController@index');

	Route::get('admin/add','AdminUserController@add');

	Route::post('admin/doAdd','AdminUserController@doAdd');

	Route::get('admin/edit/{id}','AdminUserController@edit');

	Route::post('admin/update/{id}','AdminUserController@update');

	Route::post('admin/del/{id}','AdminUserController@del');

	Route::post('admin/status','AdminUserController@status');

	Route::get('role/index','RoleController@index');

	Route::get('role/add','RoleController@add');

	Route::get('permission/index','PermissionController@index');

	Route::get('permission/add','PermissionController@add');

	Route::post('permission/doAdd','PermissionController@doAdd');




});