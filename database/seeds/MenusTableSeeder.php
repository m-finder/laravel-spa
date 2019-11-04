<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = new \App\Models\Menu();
        $db->id = 1;
        $db->parent_id = 0;
        $db->name = '首页';
        $db->url = '/dashboard';
        $db->icon = 'dashboard';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 2;
        $db->parent_id = 0;
        $db->name = '角色管理';
        $db->url = '/role';
        $db->icon = 'role';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 3;
        $db->parent_id = 2;
        $db->name = '角色列表';
        $db->url = '/role/list';
        $db->icon = 'list';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 4;
        $db->parent_id = 2;
        $db->name = '权限分配';
        $db->url = '/role/role-permission';
        $db->icon = 'security';
        $db->save();


    }
}
