<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function updateTable(){
//        Schema::drop('product_images');
//        Schema::drop('products');
        Schema::table('products',function($table){
////            $table->boolean('isDone')->default(false);//规格
////            $table->unsignedInteger('orderId');//记录备注
////            $table->foreign('orderId')->references('id')->on('ordinary_orders')->onDelete('cascade');
////            $table->unsignedInteger('orderId');//记录备注
////            $table->foreign('orderId')->references('id')->on('ordinary_orders')->onDelete('cascade');
////            $table->dropColumn('ordinary_order_id');
////            $table->unsignedInteger('ordinary_order_id');//管理员id
////            $table->dateTime('time')->nullable();
////            ordinary_order_id
////            ordinary_record_id
//
////            $table->string('describe')->nullable();//订单描述
////            $table->string('_number')->nullable();//订单流水号
////            $table->string('size')->nullable();//规格
//
////            $table->foreign('Cid')->references('id')->on('courses')->onDelete('cascade');
////            $table->dateTime('time')->default(date("Y-m-d H:i:s"));//购买(添加)时间
//
////            $table->dropForeign('ordinary_records_orderId_foreign');
////            $table->string('describe')->nullable();//订单描述
////            $table->string('_number')->nullable()->default(time());//订单流水号
////            $table->string('phone');
//
////            $table->string('openCallOverTime')->default(date('Y-m-d H:i:s',time()));//地理位置更新时间
////            $table->foreign('TeacherId')->references('id')->on('teachers');
////            $table->foreign('TeacherName')->references('name')->on('teachers');
//
////            $table->double('longitude');
////            $table->double('latitude');
////        return '更新表成功！';
//
//            $table->string('No')->nullable();
//            $table->string('productName')->nullable();
//            $table->string('unit')->nullable();
//            $table->float('unitPrice')->nullable();
//            $table->integer('count')->nullable();
//            $table->string('position')->nullable();
//            $table->string('describe')->nullable();
//            $table->string('imageList')->nullable();

//            $table->string('size')->nullable();
//            $table->string('fileOriginalName')->nullable();//文件原名名
//            $table->string('fileRealName')->nullable();//文件路径
//            $table->unsignedInteger('productId');//文件路径
//            $table->foreign('productId')->references('id')->on('products')->onDelete('cascade');
        });
    }
}
