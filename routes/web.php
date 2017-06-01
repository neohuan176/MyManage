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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * 后台页面路由
 */
Route::group(['prefix' => 'admin','namespace' => 'Backend'],function (){
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/companyManage', 'AdminController@companyManage')->name('admin.companyManage');
    Route::post('/addCompany', 'AdminController@addCompany')->name('admin.addCompany');//添加，修改公司信息
    Route::post('/deleteCompany/{companyId}', 'AdminController@deleteCompany')->name('admin.deleteCompany');//根据id删除公司
    Route::get('/showOrderByCompany/{companyId}', 'AdminController@showOrderByCompany')->name('admin.showOrderByCompany');//显示单个公司的订单
    Route::post('/addCompanyRecord/{companyId}', 'AdminController@addCompanyRecord')->name('admin.addCompanyRecord');//显示单个公司的订单
    Route::post('/delRecordById/{recordId}', 'AdminController@delRecordById')->name('admin.delRecordById');//根据id删除公司订单记录
    Route::post('/alterRecordById', 'AdminController@alterRecordById')->name('admin.alterRecordById');//根据id修改订单记录
    Route::post('/delSelectedRecord', 'AdminController@delSelectedRecord')->name('admin.delSelectedRecord');//批量删除公司订单记录
});


/**
 * 工具路由
 */
Route::group([],function (){
    Route::get('/updateTable', 'HomeController@updateTable')->name('updateTable');
});
