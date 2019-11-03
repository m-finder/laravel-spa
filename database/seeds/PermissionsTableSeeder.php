<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = new \App\Models\Permission();
        $db->parent_id = 0;
        $db->name = 'Root';
        $db->alias = '根目录';
        $db->component = 'Layout';
        $db->redirect = '/dashboard';
        $db->path = '/';
        $db->save();

        $db = new \App\Models\Permission();
        $db->parent_id = 1;
        $db->name = 'Dashboard';
        $db->alias = '首页';
        $db->component = './dashboard/Index';
        $db->path = 'dashboard';
        $db->save();
    }
}
