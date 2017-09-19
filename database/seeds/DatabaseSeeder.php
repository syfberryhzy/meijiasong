<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminMenuTableSeeder::class);
        $this->call(AdminRoleMenuTableSeeder::class);

        $this->call(PaysTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ShelvesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(AdminConfigTableSeeder::class);
    }
}
