<?php

use Illuminate\Database\Seeder;

class ShelvesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '55',
            'attributes' => '余额充值',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '200',
            'attributes' => '余额充值',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '400',
            'attributes' => '余额充值',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '600',
            'attributes' => '余额充值',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '800',
            'attributes' => '余额充值',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '1000',
            'attributes' => '余额充值',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);


        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '农夫山泉19升桶装水',
            'attributes' => '重量',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '金沙泉17升天然水',
            'attributes' => '重量',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '农夫山泉天然水（升）',
            'attributes' => '重量',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '农夫山泉天然水（毫升）',
            'attributes' => '重量',
            'image' => '["images\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\/910ee68929ab569882e89a7fbf42c127.jpeg","images\/a561ae268d915f96f428fef92076688e.jpeg"]',
            'status' => 1,
        ]);
    }
}
