<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('adminId');//管理员id
            $table->string('name')->nullable();//客户姓名
            $table->string('phone')->nullable();//电话
            $table->string('address')->nullable();//详细住址
            $table->string('fax')->nullable();//传真
            $table->string('sex')->nullable();//性别
            $table->string('email')->nullable();//邮箱
            $table->string('describe')->nullable();//备注
            $table->string('position')->nullable();//地图位置
            $table->double('lng')->nullable();//经度
            $table->double('lat')->nullable();//纬度
            $table->foreign('adminId')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
