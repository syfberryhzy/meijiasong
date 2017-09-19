<?php

use Illuminate\Database\Seeder;
use App\Models\Pay;

class PaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pay = Pay::firstOrNew([
                'name' => '余额支付',
        ]);
        if (!$pay->exists) {
            $pay->fill([
                'is_deductible' => 0,
                'is_reward'  => 0,
                'proportion' => '1.00',
                'status'     => 1,
                'description' => '美家配送，一键到家，微信支付更有积分赠送',
            ])->save();
        }

        $pay = Pay::firstOrNew([
                'name' => '微信支付',
        ]);
        if (!$pay->exists) {
            $pay->fill([
                'is_deductible' => 1,
                'is_reward'  => 1,
                'proportion' => '1.00',
                'status'     => 1,
                'description' => '美家配送，一键到家，微信支付更有积分赠送',
            ])->save();
        }

        $pay = Pay::firstOrNew([
                'name' => '货到付款',
        ]);
        if (!$pay->exists) {
            $pay->fill([
                'is_deductible' => 0,
                'is_reward'  => 0,
                'proportion' => '1.00',
                'status'     => 1,
                'description' => '美家配送，一键到家，微信支付更有积分赠送',
            ])->save();
        }
    }
}
