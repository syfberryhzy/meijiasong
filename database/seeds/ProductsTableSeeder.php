<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'shelf_id' => 1,
            'characters' => '充50得55，多充多送，优惠多多',
            'content' => '充50得55，多充多送，优惠多多',
            'price'  => '50.00',
            'is_default' => 0,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 2,
            'characters' => '充100得200，多充多送，优惠多多',
            'content' => '充100得200，多充多送，优惠多多',
            'price'  => '100.00',
            'is_default' => 0,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 3,
            'characters' => '充200得400，多充多送，优惠多多',
            'content' => '充200得400，多充多送，优惠多多',
            'price'  => '200.00',
            'is_default' => 0,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 4,
            'characters' => '充300得600，多充多送，优惠多多',
            'content' => '充300得600，多充多送，优惠多多',
            'price'  => '300.00',
            'is_default' => 0,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 5,
            'characters' => '充400得800，多充多送，优惠多多',
            'content' => '充400得800，多充多送，优惠多多',
            'price'  => '400.00',
            'is_default' => 0,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 6,
            'characters' => '充500得1000，多充多送，优惠多多',
            'content' => '充500得1000，多充多送，优惠多多',
            'price'  => '500.00',
            'is_default' => 0,
            'status' => 1,
        ]);

        #
        DB::table('products')->insert([
            'shelf_id' => 7,
            'characters' => '19L',
            'content' => '订农夫山泉桶装水与家人共同分享天然弱碱性水的健康与品质！',
            'price'  => '22.00',
            'is_default' => 1,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 8,
            'characters' => '17L',
            'content' => '唐代宫廷御贡金沙泉，点滴沉睡千百年，健康之水金沙泉！',
            'price'  => '15.00',
            'is_default' => 1,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 9,
            'characters' => '2L',
            'content' => '一箱8瓶，水源地杭州千岛湖',
            'price'  => '35.00',
            'is_default' => 1,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 9,
            'characters' => '4L',
            'content' => '一箱4瓶，水源地杭州千岛湖，天然弱碱性水！',
            'price'  => '38.00',
            'is_default' => 1,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'shelf_id' => 9,
            'characters' => '5L',
            'content' => '一箱4瓶，水源地杭州千岛湖，天然弱碱性水！',
            'price'  => '40.00',
            'is_default' => 1,
            'status' => 1,
        ]);
    }
}
