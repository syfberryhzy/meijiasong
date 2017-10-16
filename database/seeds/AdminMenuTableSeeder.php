<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('admin_menu')->insert([
          // 'id'        => 8,
          'parent_id' => 0,
          'order'     => 21,
          'title'     => '美家送',
          'icon'      => 'fa-truck',
          'uri'       => '/distribution',
        ]);

        DB::table('admin_menu')->insert([
          // 'id'        => 9,
          'parent_id' => 0,
          'order'     => 8,
          'title'     => '用户组',
          'icon'      => 'fa-users',
          'uri'       => '/usergroup',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 10,
          'parent_id' => 0,
          'order'     => 13,
          'title'     => '商品台',
          'icon'      => 'fa-university',
          'uri'       => '/goods',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 11,
          'parent_id' => 10,
          'order'     => 15,
          'title'     => '货架',
          'icon'      => 'fa-paw',
          'uri'       => '/goods/shelfs',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 12,
          'parent_id' => 10,
          'order'     => 16,
          'title'     => '商品',
          'icon'      => 'fa-shopping-basket',
          'uri'       => '/goods/products',
        ]);

        DB::table('admin_menu')->insert([
          // 'id'        => 13,
          'parent_id' => 10,
          'order'     => 14,
          'title'     => '分类',
          'icon'      => 'fa-star-half-o',
          'uri'       => '/goods/categories',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 14,
          'parent_id' => 0,
          'order'     => 17,
          'title'     => '订单',
          'icon'      => 'fa-sitemap',
          'uri'       => '/orders',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 15,
          'parent_id' => 14,
          'order'     => 19,
          'title'     => '订购',
          'icon'      => 'fa-television',
          'uri'       => '/orders/order_menus',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 16,
          'parent_id' => 14,
          'order'     => 18,
          'title'     => '支付方式',
          'icon'      => 'fa-paypal',
          'uri'       => '/orders/pays',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 17,
          'parent_id' => 9,
          'order'     => 9,
          'title'     => '用户',
          'icon'      => 'fa-user-plus',
          'uri'       => '/usergroup/users',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 18,
          'parent_id' => 9,
          'order'     => 11,
          'title'     => '积分明细',
          'icon'      => 'fa-print',
          'uri'       => '/usergroup/integrals',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 19,
          'parent_id' => 9,
          'order'     => 12,
          'title'     => '余额明细',
          'icon'      => 'fa-balance-scale',
          'uri'       => '/usergroup/balances',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 20,
          'parent_id' => 14,
          'order'     => 20,
          'title'     => '配送',
          'icon'      => 'fa-paper-plane-o',
          'uri'       => '/orders/sends',
        ]);
        DB::table('admin_menu')->insert([
          // 'id'        => 21,
          'parent_id' => 8,
          'order'     => 22,
          'title'     => '商家配置',
          'icon'      => 'fa-map-signs',
          'uri'       => '/config',
        ]);
    }
}
