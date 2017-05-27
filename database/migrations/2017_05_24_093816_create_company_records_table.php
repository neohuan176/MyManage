<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('companyId');//公司Id
            $table->string('name');//联系人(购买商品的人)，默认使用公司联系人
            $table->string('phone');//购买个人联系电话，默认使用公司联系电话
            $table->string('product');//产品名称
            $table->string('unit');//单位
            $table->string('unitPrice');//单位
            $table->integer('count');//购买数量
            $table->float('tootlePrice');//总价格
            $table->dateTime('time');//购买时间
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
        Schema::dropIfExists('company_records');
    }
}
