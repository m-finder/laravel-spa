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
        $db->name = 'Auth';
        $db->title = '权限管理';
        $db->path = '/auth';
        $db->icon = 'security';
        $db->redirect = '/auth/roles';
        $db->component = 'Layout';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 2;
        $db->parent_id = 1;
        $db->name = 'RoleList';
        $db->title = '角色列表';
        $db->path = '/auth/roles';
        $db->icon = 'role';
        $db->component = './admin/views/roles/Index';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 3;
        $db->parent_id = 1;
        $db->name = 'AdminList';
        $db->title = '用户列表';
        $db->path = '/auth/admins';
        $db->icon = 'user';
        $db->component = './admin/views/admins/Index';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 4;
        $db->parent_id = 1;
        $db->name = 'MenuList';
        $db->title = '权限管理';
        $db->path = '/auth/menus';
        $db->icon = 'security';
        $db->component = './admin/views/menus/Index';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 5;
        $db->parent_id = 0;
        $db->name = 'Base';
        $db->title = '其他';
        $db->path = '/base';
        $db->icon = 'smile';
        $db->component = 'Layout';
        $db->redirect = '/base/icons';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 6;
        $db->parent_id = 5;
        $db->name = 'Icons';
        $db->title = '图标';
        $db->path = '/base/icons';
        $db->icon = 'smile';
        $db->component = './admin/views/icons/Index';
        $db->save();
    }
}
