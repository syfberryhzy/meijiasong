<?php

use Illuminate\Database\Seeder;

class ShelvesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shelves')->delete();
        
        \DB::table('shelves')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 1,
                'name' => '55',
                'attributes' => '余额充值',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 1,
                'name' => '200',
                'attributes' => '余额充值',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => 1,
                'name' => '400',
                'attributes' => '余额充值',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'category_id' => 1,
                'name' => '600',
                'attributes' => '余额充值',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'category_id' => 1,
                'name' => '800',
                'attributes' => '余额充值',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'category_id' => 1,
                'name' => '1000',
                'attributes' => '余额充值',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'category_id' => 2,
                'name' => '农夫山泉19升桶装水',
                'attributes' => '重量',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg","images\\/5a0100abNbeabd64d.jpg","images\\/57e4ce64N89d33888.jpg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => '2017-11-08 10:29:31',
            ),
            7 => 
            array (
                'id' => 8,
                'category_id' => 2,
                'name' => '金沙泉17升天然水',
                'attributes' => '重量',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'category_id' => 2,
                'name' => '农夫山泉天然水（升）',
                'attributes' => '重量',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'category_id' => 2,
                'name' => '农夫山泉天然水（毫升）',
                'attributes' => '重量',
                'image' => '["images\\/bbed53c57925c69bcb1339c5bdcb1883.jpeg","images\\/910ee68929ab569882e89a7fbf42c127.jpeg","images\\/a561ae268d915f96f428fef92076688e.jpeg"]',
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'category_id' => 2,
                'name' => '天地精华 饮用天然矿泉水 4.5L*4桶/箱 泡茶水',
                'attributes' => '箱',
                'image' => '["images\\/05f5247a6378d93ca05f71b379602cd7.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:10:34',
                'updated_at' => '2017-11-08 11:10:34',
            ),
            11 => 
            array (
                'id' => 12,
                'category_id' => 3,
                'name' => '沁园（QINYUAN）YL9725W 家用立式双门 温热型饮水机',
                'attributes' => '件',
                'image' => '["images\\/59c4df3eN9d672965.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:12:49',
                'updated_at' => '2017-11-08 11:12:49',
            ),
            12 => 
            array (
                'id' => 13,
                'category_id' => 3,
                'name' => '海斯曼（F;HESEME） 9605饮水机 立式温热型家用饮水器',
                'attributes' => '件',
                'image' => '["images\\/59facea0Na311ac83.jpg","images\\/59facea2N507bec93.jpg","images\\/59fbdfa8N6f6a22ca.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:13:31',
                'updated_at' => '2017-11-08 11:13:31',
            ),
            13 => 
            array (
                'id' => 14,
                'category_id' => 3,
                'name' => '彩虹饮台式白色迷你款小型 温热/冷热两用可选 饮水器',
                'attributes' => '件',
                'image' => '["images\\/9c07e0b092dfeda57b6abaec2fa75325.jpg","images\\/b263e5a9fc3cb585f893f7ae6edbe06d.jpg","images\\/59a9478bN827079e9.jpg","images\\/5ddf908aaf671d9d6a0e78082cc4a1ed.jpg","images\\/99278aa3f34f80f4f9d87d01838fc3df.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:18:14',
                'updated_at' => '2017-11-08 11:18:14',
            ),
            14 => 
            array (
                'id' => 15,
                'category_id' => 4,
                'name' => '市中心两小时内送水到府',
                'attributes' => '虚拟',
                'image' => '["images\\/\\u5fae\\u4fe1\\u56fe\\u7247_20171108103013.jpg","images\\/\\u5fae\\u4fe1\\u56fe\\u7247_20171108103031.jpg","images\\/\\u5fae\\u4fe1\\u56fe\\u7247_20171108103036.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:21:39',
                'updated_at' => '2017-11-08 11:21:39',
            ),
            15 => 
            array (
                'id' => 16,
                'category_id' => 4,
                'name' => '桶装水水桶押金30元每个',
                'attributes' => '虚拟',
                'image' => '["images\\/58d6cc463a40add75b7059b10929fd67.jpg","images\\/8ec48afa91c78e0b6cbf4c6961b744bc.jpg","images\\/b1cfe4955a27164e12406633818ee2f9.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:22:36',
                'updated_at' => '2017-11-08 11:22:36',
            ),
            16 => 
            array (
                'id' => 17,
                'category_id' => 4,
                'name' => '单位团购',
                'attributes' => '虚拟',
                'image' => '["images\\/1cccc1a472c9b01b80337153b9124a3d.jpg","images\\/cf90daa5207cd94fac30e9216843743e.jpg","images\\/25a48e3a3db72660a9bf62f9c9daa4c9.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:23:07',
                'updated_at' => '2017-11-08 11:23:07',
            ),
            17 => 
            array (
                'id' => 18,
                'category_id' => 5,
                'name' => '天然矿泉水、矿物质水、天然水、纯净水的区别',
                'attributes' => '虚拟',
                'image' => '["images\\/\\u5fae\\u4fe1\\u56fe\\u7247_20171108112520.jpg"]',
                'status' => 1,
                'created_at' => '2017-11-08 11:25:33',
                'updated_at' => '2017-11-08 11:25:33',
            ),
        ));
        
        
    }
}