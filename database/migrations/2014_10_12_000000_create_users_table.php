<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('openid')->comment('微信标识');
            $table->decimal('integral', 10, 2)->comment('积分')->default('0.00');
            $table->decimal('balance', 10, 2)->comment('微信标识')->default('0.00');
            $table->string('lat')->comment('经度')->nullable();
            $table->string('lng')->comment('纬度')->nullable();
            $table->tinyInteger('gender')->comment('性别1=男,2=女')->default(1);
            $table->tinyInteger('status')->comment('状态')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
