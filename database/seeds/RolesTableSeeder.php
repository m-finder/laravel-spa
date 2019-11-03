<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = new \App\Models\Role();
        $db->name = 'super-admin';
        $db->alias = '超级管理员';
        $db->save();
    }
}
