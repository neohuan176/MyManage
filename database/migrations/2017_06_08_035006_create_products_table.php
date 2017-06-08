<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('No')->nullable();
            $table->string('productName')->nullable();
            $table->string('unit')->nullable();
            $table->string('size')->nullable();
            $table->float('unitPrice')->nullable();
            $table->integer('count')->nullable();
            $table->string('position')->nullable();
            $table->string('describe')->nullable();
            $table->string('imageList')->nullable();
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
        Schema::dropIfExists('products');
    }
}
