<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 21,
                'title' => '美家送',
                'icon' => 'fa-truck',
                'uri' => '/distribution',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 8,
                'title' => '用户组',
                'icon' => 'fa-users',
                'uri' => '/usergroup',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'order' => 13,
                'title' => '商品台',
                'icon' => 'fa-university',
                'uri' => '/goods',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 10,
                'order' => 15,
                'title' => '货架',
                'icon' => 'fa-paw',
                'uri' => '/goods/shelfs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 10,
                'order' => 16,
                'title' => '商品',
                'icon' => 'fa-shopping-basket',
                'uri' => '/goods/products',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 10,
                'order' => 14,
                'title' => '分类',
                'icon' => 'fa-star-half-o',
                'uri' => '/goods/categories',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 0,
                'order' => 17,
                'title' => '订单',
                'icon' => 'fa-sitemap',
                'uri' => '/orders',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 14,
                'order' => 19,
                'title' => '订购',
                'icon' => 'fa-television',
                'uri' => '/orders/order_menus',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 14,
                'order' => 18,
                'title' => '支付方式',
                'icon' => 'fa-paypal',
                'uri' => '/orders/pays',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 9,
                'order' => 9,
                'title' => '用户',
                'icon' => 'fa-user-plus',
                'uri' => '/usergroup/users',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 9,
                'order' => 11,
                'title' => '积分明细',
                'icon' => 'fa-print',
                'uri' => '/usergroup/integrals',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 9,
                'order' => 12,
                'title' => '余额明细',
                'icon' => 'fa-balance-scale',
                'uri' => '/usergroup/balances',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 14,
                'order' => 20,
                'title' => '配送',
                'icon' => 'fa-paper-plane-o',
                'uri' => '/orders/sends',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => 8,
                'order' => 22,
                'title' => '商家配置',
                'icon' => 'fa-map-signs',
                'uri' => '/config',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}