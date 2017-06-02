<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void                  要增加订单号，描述。
     */
    public function up()
    {
        Schema::create('company_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('companyId');//公司Id
            $table->string('name')->nullable();//联系人(购买商品的人)，默认使用公司联系人
            $table->string('phone')->nullable();//购买个人联系电话，默认使用公司联系电话
            $table->string('product')->nullable();//产品名称
            $table->string('unit')->nullable();//单位
            $table->string('unitPrice')->nullable();//单价
            $table->integer('count')->nullable();//购买数量
            $table->float('totalPrice')->nullable();//总价格
            $table->dateTime('time')->nullable();//购买(添加)时间
            $table->string('describe')->nullable();//订单描述
            $table->string('_number')->nullable();//订单流水号
            $table->string('size')->nullable();//规格
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('cascade');
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
