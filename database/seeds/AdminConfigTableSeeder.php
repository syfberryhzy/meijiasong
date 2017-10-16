<?php

use Illuminate\Database\Seeder;
use App\Models\AdminConfig as Config;

class AdminConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = Config::firstOrNew([
                'name' => '店铺名称',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '美加送水站',
                'description'  => '美加送水站'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '开店时间',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '8:00-16:00',
                'description'  => '每日开店时间-打烊时间'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '配送时间',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '8:00-16:00',
                'description'  => '120'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '商家地址',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '浙江省湖州市红丰路655号,商住楼30幢红丰路609号',
                'description'  => '商家地址'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '商家电话',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '0571-2076662',
                'description'  => '商家电话'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '配送信息',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '由商家提供配送，约28分钟送达，距离100m以内免配送费',
                'description'  => '由商家提供配送，约28分钟送达，距离100m以内免配送费'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '活动信息',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '中高端饮用水订购中心',
                'description'  => '中高端饮用水订购中心'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '服务信息',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '该商家支持开发票，开票订单金额500.0元起，请在下单时填写发票抬头',
                'description'  => '该商家支持开发票，开票订单金额500.0元起，请在下单时填写发票抬头'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '起送标准',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => "0-5:100
5-10:300
10-15:500
15-50:1000",
                'description'  => '起送标准'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '商家LOGO',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => 'images/9f4c35618f6c6938992c6d757691e980.png',
                'description'  => '商家图片，第一张默认为logo图片'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '商家图片1',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => 'images/20170901162108.jpg',
                'description'  => '商家图片，第一张默认为logo图片'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '商家图片2',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => 'images/bf7c4d508e6e3b015dc94591105ee574.jpeg'
                'description'  => '商家图片，第一张默认为logo图片'
            ])->save();
        }

        $config = Config::firstOrNew([
                'name' => '商家图片3',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => 'images/20170901162126.jpg',
                'description'  => '商家图片，第一张默认为logo图片'
            ])->save();
        }
        $config = Config::firstOrNew([
                'name' => '商品抵扣比例',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '10:1',
                'description'  => '积分:现金'
            ])->save();
        }
    }
}
