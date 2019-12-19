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
        $db->name = 'Home';
        $db->title = '初始菜单';
        $db->path = '/';
        $db->icon = 'dashboard';
        $db->redirect = '/dashboard';
        $db->component = 'Layout';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 2;
        $db->parent_id = 1;
        $db->name = 'Dashboard';
        $db->title = '首页';
        $db->path = '/dashboard';
        $db->icon = 'dashboard';
        $db->component = '/dashboard/Index';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 3;
        $db->parent_id = 0;
        $db->name = 'Auth';
        $db->title = '权限管理';
        $db->path = '/auth';
        $db->icon = 'security';
        $db->redirect = '/auth/roles';
        $db->component = 'Layout';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 4;
        $db->parent_id = 3;
        $db->name = 'RoleList';
        $db->title = '角色列表';
        $db->path = '/auth/roles';
        $db->icon = 'role';
        $db->component = '/roles/Index';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 5;
        $db->parent_id = 3;
        $db->name = 'AdminList';
        $db->title = '用户列表';
        $db->path = '/auth/admins';
        $db->icon = 'user';
        $db->component = '/admins/Index';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 6;
        $db->parent_id = 3;
        $db->name = 'MenuList';
        $db->title = '权限管理';
        $db->path = '/auth/menus';
        $db->icon = 'security';
        $db->component = '/menus/Index';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 7;
        $db->parent_id = 0;
        $db->name = 'Base';
        $db->title = '其他';
        $db->path = '/base';
        $db->icon = 'smile';
        $db->component = 'Layout';
        $db->redirect = '/base/icons';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 8;
        $db->parent_id = 5;
        $db->name = 'Icons';
        $db->title = '图标';
        $db->path = '/base/icons';
        $db->icon = 'smile';
        $db->component = '/icons/Index';
        $db->save();
    }
}
