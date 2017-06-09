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
 * 后台页面路由---------->公司客户管理
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
    Route::get('/exportCompanyToExcel/{companyId}', 'AdminController@exportCompanyToExcel')->name('admin.exportCompanyToExcel');//导出公司订单数据（excel）
    Route::get('/showCompanyInfo/{companyId}', 'AdminController@showCompanyInfo')->name('admin.showCompanyInfo');//显示公司详细信息
    Route::get('/getDataTest/{companyId}', 'AdminController@getDataTest')->name('admin.getDataTest');//测试Vue
    Route::post('/changeOrderStatus', 'AdminController@changeOrderStatus')->name('admin.changeOrderStatus');//修改完成状态
});

/**
 * 后台页面路由---------->个人客户管理
 */
Route::group(['prefix' => 'admin/personal/','namespace' => 'Backend'],function (){
    Route::get('/personalClientManage', 'PersonalClientController@personalClientManage')->name('admin.personal.personalClientManage');
    Route::post('/addPersonalClient', 'PersonalClientController@addPersonalClient')->name('admin.personal.addPersonalClient');//添加，修改公司信息
    Route::post('/deletePersonalClient/{clientId}', 'PersonalClientController@deletePersonalClient')->name('admin.personal.deletePersonalClient');//根据id删除公司
    Route::get('/showOrderByPersonalClient/{clientId}', 'PersonalClientController@showOrderByPersonalClient')->name('admin.personal.showOrderByPersonalClient');//显示单个客户的订单
    Route::post('/addClientRecord/{clientId}', 'PersonalClientController@addClientRecord')->name('admin..personal.addClientRecord');//添加个人客户的订单
    Route::post('/delRecordById/{recordId}', 'PersonalClientController@delRecordById')->name('admin.delRecordById');//根据id删除个人订单记录
    Route::post('/alterRecordById', 'PersonalClientController@alterRecordById')->name('admin.alterRecordById');//根据id修改订单记录
    Route::post('/delSelectedRecord', 'PersonalClientController@delSelectedRecord')->name('admin.delSelectedRecord');//批量删除个人订单记录
    Route::get('/exportClientRecordToExcel/{clientId}', 'PersonalClientController@exportClientRecordToExcel')->name('admin.personal.exportClientRecordToExcel');//导出个人订单数据（excel）
    Route::get('/showClientInfo/{clientId}', 'PersonalClientController@showClientInfo')->name('admin.personal.showClientInfo');//显示个人详细信息
    Route::get('/getClientInfo/{clientId}', 'PersonalClientController@getClientInfo')->name('admin.personal.getClientInfo');//获取客户 信息
    Route::post('/changeOrderStatus', 'PersonalClientController@changeOrderStatus')->name('admin.personal.changeOrderStatus');//修改完成状态
});


/**
 * 后台页面路由---------->订单管理
 */
Route::group(['prefix' => 'admin/orders/','namespace' => 'Backend'],function (){
    Route::get('/companyOrdersManage', 'OrderController@companyOrdersManage')->name('admin.orders.companyOrdersManage');//公司订单管理
    Route::get('/clientOrdersManage', 'OrderController@clientOrdersManage')->name('admin.orders.clientOrdersManage');//个人订单管理
    Route::get('/ordinaryOrdersManage', 'OrderController@ordinaryOrdersManage')->name('admin.orders.ordinaryOrdersManage');//常规订单管理
    //    添加订单
    Route::post('/addOrdinaryOrder', 'OrderController@addOrdinaryOrder')->name('admin.orders.addOrdinaryOrder');
    //    修改订单
    //    删除订单
    Route::post('/delOrdinaryOrderById/{orderId}', 'OrderController@delOrdinaryOrderById')->name('admin.orders.delOrdinaryOrderById');
    Route::post('/delSelectedOrders', 'OrderController@delSelectedOrders')->name('admin.orders.delSelectedOrders');
    Route::get('/getOrderRecords', 'OrderController@getOrderRecords')->name('admin.orders.getOrderRecords');//
    Route::post('/alterOrderById', 'OrderController@alterOrderById')->name('admin.orders.alterOrderById');//
    Route::post('/delOrdinaryRecordById/{recordId}', 'OrderController@delOrdinaryRecordById')->name('admin.orders.delOrdinaryRecordById');//获取订单的记录
    //    查找订单

    Route::post('/changeOrderStatus/{type}', 'OrderController@changeOrderStatus')->name('admin.orders.changeOrderStatus');//修改完成状态
    Route::get('/exportClientOrders', 'OrderController@exportClientOrders')->name('admin.orders.exportClientOrders');//导出所有个人客户购买记录
    Route::get('/exportCompanyOrders', 'OrderController@exportCompanyOrders')->name('admin.orders.exportCompanyOrders');//导出所有公司购买记录


});


/**
 * 后台页面路由---------->订单管理
 */
Route::group(['prefix' => 'admin/stock/','namespace' => 'Backend'],function (){
    Route::get('/stockAdd', 'StockController@stockAdd')->name('admin.stock.stockAdd');//添加库存页面
    Route::get('/stockShow', 'StockController@stockShow')->name('admin.stock.stockShow');//显示库存页面
    Route::post('/addProducts', 'StockController@addProducts')->name('admin.stock.addProducts');//保存产品
    Route::post('/getAllProducts', 'StockController@getAllProducts')->name('admin.stock.getAllProducts');//
    Route::post('/delProduct', 'StockController@delProduct')->name('admin.stock.delProduct');//删除产品
    Route::post('/changeCount', 'StockController@changeCount')->name('admin.stock.changeCount');//修改库存
    Route::get('/getProduct/{productId}', 'StockController@getProduct')->name('admin.stock.getProduct');//修改库存
    Route::any('/alterProduct/{productId?}', 'StockController@alterProduct')->name('admin.stock.alterProduct');//修改库存
    Route::post('/imageUpload', 'StockController@imageUpload')->name('admin.stock.imageUpload');
    Route::post('/alter/imageUpload/{productId}', 'StockController@imageUploadAlter')->name('admin.stock.imageUploadAlter');
    Route::post('/alter/delProductImage', 'StockController@delProductImage')->name('admin.stock.delProductImage');
//    Route::post('/alter/saveAlterProduct', 'StockController@alterProduct')->name('admin.stock.saveAlterProduct');
});



/**
 * 工具路由
 */
Route::group([],function (){
    Route::get('/updateTable', 'HomeController@updateTable')->name('updateTable');//更新表
});
