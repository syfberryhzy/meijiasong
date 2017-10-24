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
            $table->unsignedInteger('shelf_id');
            // $table->foreign('shelf_id')->references('id')->on('shelves');
            $table->string('characters')->comment('对应属性');
            $table->text('content')->comment('简介');
            $table->decimal('price', 10, 2)->comment('价格')->default('0.00');
            $table->tinyInteger('is_default')->comment('是否抵扣积分0/1')->default(1);
            $table->integer('sales')->comment('销量')->default(0);
            $table->integer('points')->comment('抵扣积分')->default(10);
            $table->tinyInteger('status')->comment('状态')->default(1);
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
