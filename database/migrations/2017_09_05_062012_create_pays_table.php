<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->comment('支付方式')->nullable();
            $table->string('description', 50)->comment('简述')->nullable();
            $table->tinyInteger('is_deductible')->comment('是否抵扣积分 0/1')->default(0);
            $table->tinyInteger('is_reward')->comment('是否奖励积分 0/1')->default(0);
            $table->decimal('proportion', 5, 2)->comment('现金:积分比例值')->default('0.01');
            $table->tinyInteger('status')->comment('状态0/1')->default(1);
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
        Schema::dropIfExists('pays');
    }
}
