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
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '200',
            'attributes' => '余额充值',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '400',
            'attributes' => '余额充值',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '600',
            'attributes' => '余额充值',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '800',
            'attributes' => '余额充值',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 1,
            'name' => '1000',
            'attributes' => '余额充值',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);


        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '农夫山泉19升桶装水',
            'attributes' => '重量',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '金沙泉17升天然水',
            'attributes' => '重量',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '农夫山泉天然水（升）',
            'attributes' => '重量',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
        DB::table('shelves')->insert([
            'category_id' => 2,
            'name' => '农夫山泉天然水（毫升）',
            'attributes' => '重量',
            'image' => 'images/1284e10d4c9205af1c514d1bf40580e9.jpeg',
            'status' => 1,
        ]);
    }
}
