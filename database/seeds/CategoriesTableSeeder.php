<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'title' => '充值中心',
            'description' => '余额充值，多充多送，优惠多多',
            'type' => 0,
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'title' => '饮用水',
            'description' => '桶装水、瓶装水、袋装水！',
            'type' => 1,
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'title' => '饮水器',
            'description' => '饮水机、电动抽水器、压水器',
            'type' => 1,
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'title' => '订购须知',
            'description' => '关于送货时间',
            'type' => 0,
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'title' => '科普知识',
            'description' => '科普水知识，先了解再订水。',
            'type' => 0,
            'status' => 1,
        ]);
    }
}
