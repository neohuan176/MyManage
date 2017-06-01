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
        Schema::table('company_records',function($table){
//            $table->dropColumn('_number');
            $table->string('_number')->nullable();//总价格


//            $table->foreign('Cid')->references('id')->on('courses')->onDelete('cascade');
//            $table->dateTime('time')->default(date("Y-m-d H:i:s"));//购买(添加)时间

//            $table->dropForeign('attend_records_Cid_foreign');
//            $table->string('describe')->nullable();//订单描述
//            $table->string('_number')->nullable()->default(time());//订单流水号
//            $table->string('phone');

//            $table->string('openCallOverTime')->default(date('Y-m-d H:i:s',time()));//地理位置更新时间
//            $table->foreign('TeacherId')->references('id')->on('teachers');
//            $table->foreign('TeacherName')->references('name')->on('teachers');

//            $table->double('longitude');
//            $table->double('latitude');
//        return '更新表成功！';
        });
    }
}
