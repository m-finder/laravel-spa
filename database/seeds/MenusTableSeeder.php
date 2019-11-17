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
        $db->name = '权限管理';
        $db->url = '/auth';
        $db->icon = 'security';
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
        $db->name = '用户列表';
        $db->url = '/admin/list';
        $db->icon = 'user';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 5;
        $db->parent_id = 2;
        $db->name = '权限列表';
        $db->url = '/permission/list';
        $db->icon = 'security';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 6;
        $db->parent_id = 2;
        $db->name = '菜单列表';
        $db->url = '/menu/list';
        $db->icon = 'nav-list';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 7;
        $db->parent_id = 0;
        $db->name = '其他';
        $db->url = '/base';
        $db->icon = 'smile';
        $db->save();

        $db = new \App\Models\Menu();
        $db->id = 8;
        $db->parent_id = 7;
        $db->name = '图标';
        $db->url = '/base/icons';
        $db->icon = 'smile';
        $db->save();


    }
}
