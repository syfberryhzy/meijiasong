<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedInteger('order_id');
            // $table->foreign('order_id')->references('id')->on('orders');
            $table->string('name')->comment('商品名称');
            $table->string('attributes')->comment('属性');
            $table->tinyInteger('number')->comment('数量')->default(1);
            $table->decimal('price', 10, 2)->comment('单价')->default('0.00');
            $table->decimal('amount', 10, 2)->comment('总计')->default('0.00');
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
        Schema::dropIfExists('order_items');
    }
}
