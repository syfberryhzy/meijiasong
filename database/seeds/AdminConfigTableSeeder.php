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
                'description'  => '每日配送时间'
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
                'name' => '商家图片',
        ]);
        if (!$config->exists) {
            $config->fill([
                'value' => '["images\/37cd19fb30109b3819691194f862a1e4.png","images\/\u5fae\u4fe1\u56fe\u7247_20170901162108.jpg","images\/e9144930a96e6598b69fef1690434e40.jpeg","images\/fd9ed21764be8065fb97f7c11adab44a.jpeg"]',
                'description'  => '商家图片，第一张默认为logo图片'
            ])->save();
        }


    }
}
