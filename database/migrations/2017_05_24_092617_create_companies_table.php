<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('adminId');//管理员id
            $table->string('company')->nullable();//公司名称
            $table->string('name')->nullable();//联系人姓名
            $table->string('connectType')->nullable();//联系人类型
            $table->string('phone')->nullable();//公司座机电话
            $table->string('mobilePhone')->nullable();//联系人手机号
            $table->string('fax')->nullable();//传真
            $table->string('email')->nullable();//邮箱
            $table->string('website')->nullable();//网站
            $table->string('address')->nullable();//详细地址
            $table->string('describe')->nullable();//描述
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
        Schema::dropIfExists('companies');
    }
}
