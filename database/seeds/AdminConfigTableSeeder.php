<?php

use Illuminate\Database\Seeder;

class AdminConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_config')->delete();
        
        \DB::table('admin_config')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '店铺名称',
                'value' => '美加送水站',
                'description' => '美加送水站',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '开店时间',
                'value' => '8:00-21:00',
                'description' => '每日开店时间-打烊时间',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-11-07 17:41:25',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '配送时间',
                'value' => '8:00-16:00',
                'description' => '120',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '商家地址',
                'value' => '浙江省湖州市红丰路655号,商住楼30幢红丰路609号',
                'description' => '[120.15507,30.274085]',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-30 14:27:46',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '商家电话',
                'value' => '0571-2076662',
                'description' => '商家电话',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '配送信息',
                'value' => '由商家提供配送，约28分钟送达，距离100m以内免配送费',
                'description' => '由商家提供配送，约28分钟送达，距离100m以内免配送费',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '活动信息',
                'value' => '中高端饮用水订购中心',
                'description' => '中高端饮用水订购中心',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => '服务信息',
                'value' => '该商家支持开发票，开票订单金额500.0元起，请在下单时填写发票抬头',
                'description' => '该商家支持开发票，开票订单金额500.0元起，请在下单时填写发票抬头',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '起送标准',
                'value' => '0-5:100
5-10:300
10-15:500
15-50:1000',
                'description' => '起送标准',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => '商家LOGO',
                'value' => 'images/9f4c35618f6c6938992c6d757691e980.png',
                'description' => '商家图片，第一张默认为logo图片',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => '商家图片1',
                'value' => 'images/20170901162108.jpg',
                'description' => '商家图片，第一张默认为logo图片',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => '商家图片2',
                'value' => 'images/bf7c4d508e6e3b015dc94591105ee574.jpeg',
                'description' => '商家图片，第一张默认为logo图片',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => '商家图片3',
                'value' => 'images/20170901162126.jpg',
                'description' => '商家图片，第一张默认为logo图片',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '商品抵扣比例',
                'value' => '10:1',
                'description' => '积分:现金',
                'created_at' => '2017-10-29 19:02:13',
                'updated_at' => '2017-10-29 19:02:13',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => '商家公告',
                'value' => '新客户首购桶装水需付桶押金30元每个，不用可退',
                'description' => '新客户首购桶装水需付桶押金30元每个，不用可退',
                'created_at' => '2017-10-30 11:39:40',
                'updated_at' => '2017-10-30 11:39:40',
            ),
        ));
        
        
    }
}