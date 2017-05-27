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
            $table->string('company');//公司名称
            $table->string('name');//联系人姓名
            $table->string('connectType');//联系人类型
            $table->string('phone');//公司座机电话
            $table->string('mobilePhone');//联系人手机号
            $table->string('fax');//传真
            $table->string('email');//邮箱
            $table->string('website');//网站
            $table->string('address');//详细地址
            $table->string('describe');//描述
            $table->string('position');//地图位置
            $table->double('lng');//经度
            $table->double('lat');//纬度
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
