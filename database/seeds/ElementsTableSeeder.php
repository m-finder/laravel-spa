<?php

use Illuminate\Database\Seeder;

class ElementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = new \App\Models\Element();
        $db->name = '角色列表';
        $db->menu_id = 4;
        $db->code = 'role:list';
        $db->method =  'get';
        $db->path = '/roles/list';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '所有角色';
        $db->menu_id = 4;
        $db->code = 'role:all';
        $db->method =  'get';
        $db->path = '/roles/all';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '添加角色';
        $db->menu_id = 4;
        $db->code = 'role:add';
        $db->method =  'post';
        $db->path = '/roles/create';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '修改角色';
        $db->menu_id = 4;
        $db->code = 'role:edit';
        $db->method =  'put';
        $db->path = '/roles/{*}/update';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '删除角色';
        $db->menu_id = 4;
        $db->code = 'role:delete';
        $db->method =  'delete';
        $db->path = '/roles/{*}/delete';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '角色详情';
        $db->menu_id = 4;
        $db->code = 'role:detail';
        $db->method =  'get';
        $db->path = '/roles/{*}/detail';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '角色权限';
        $db->menu_id = 4;
        $db->code = 'role:auth';
        $db->method =  'get';
        $db->path = '/roles/{*}/auth';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '分配权限';
        $db->menu_id = 4;
        $db->code = 'role:setAuth';
        $db->method =  'get';
        $db->path = '/roles/{*}/set/auth';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '所有权限';
        $db->menu_id = 4;
        $db->code = 'role:menus';
        $db->method =  'get';
        $db->path = '/menus/all/with/elements';
        $db->save();


        $db = new \App\Models\Element();
        $db->name = '用户列表';
        $db->menu_id = 5;
        $db->code = 'admin:list';
        $db->method =  'get';
        $db->path = '/admins/list';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '添加用户';
        $db->menu_id = 5;
        $db->code = 'admin:add';
        $db->method =  'post';
        $db->path = '/admins/create';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '修改用户';
        $db->menu_id = 5;
        $db->code = 'admin:edit';
        $db->method =  'put';
        $db->path = '/admins/{*}/update';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '删除用户';
        $db->menu_id = 5;
        $db->code = 'admin:delete';
        $db->method =  'delete';
        $db->path = '/admins/{*}/delete';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '用户详情';
        $db->menu_id = 5;
        $db->code = 'admin:detail';
        $db->method =  'get';
        $db->path = '/admins/{*}/detail';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '所有菜单';
        $db->menu_id = 6;
        $db->code = 'menu:all';
        $db->method =  'get';
        $db->path = '/menus/all';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '添加菜单';
        $db->menu_id = 6;
        $db->code = 'menu:add';
        $db->method =  'post';
        $db->path = '/menus/create';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '修改菜单';
        $db->menu_id = 6;
        $db->code = 'menu:edit';
        $db->method =  'put';
        $db->path = '/menus/{*}/update';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '删除菜单';
        $db->menu_id = 6;
        $db->code = 'menu:delete';
        $db->method =  'delete';
        $db->path = '/menus/{*}/delete';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '菜单详情';
        $db->menu_id = 6;
        $db->code = 'menu:detail';
        $db->method =  'get';
        $db->path = '/menus/{*}/detail';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '上级菜单';
        $db->menu_id = 6;
        $db->code = 'menu:parents';
        $db->method =  'get';
        $db->path = '/menus/parents';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '资源列表';
        $db->menu_id = 6;
        $db->code = 'elements:list';
        $db->method =  'get';
        $db->path = '/elements/list';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '添加资源';
        $db->menu_id = 6;
        $db->code = 'element:add';
        $db->method =  'post';
        $db->path = '/elements/create';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '修改资源';
        $db->menu_id = 6;
        $db->code = 'element:edit';
        $db->method =  'put';
        $db->path = '/elements/{*}/update';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '删除资源';
        $db->menu_id = 6;
        $db->code = 'element:delete';
        $db->method =  'delete';
        $db->path = '/element/{*}/delete';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '资源详情';
        $db->menu_id = 6;
        $db->code = 'element:detail';
        $db->method =  'get';
        $db->path = '/elements/{*}/detail';
        $db->save();

        $db = new \App\Models\Element();
        $db->name = '日志列表';
        $db->menu_id = 9;
        $db->code = 'logs:list';
        $db->method =  'get';
        $db->path = '/logs/list';
        $db->save();

    }
}
