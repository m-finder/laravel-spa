<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminsTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(MenusTableSeeder::class);
         $this->call(ElementsTableSeeder::class);
         $this->call(RolesPermissionsTableSeeder::class);
         $this->call(RolesElementsTableSeeder::class);
    }
}
