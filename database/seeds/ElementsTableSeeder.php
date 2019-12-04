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
        $db = new \App\Models\Elements();
        $db->name = '角色列表';
        $db->router_id = 2;
        $db->code = 'role:list';
        $db->method =  'get';
        $db->path = '/roles/list';
        $db->save();

        $db = new \App\Models\Elements();
        $db->name = '添加角色';
        $db->router_id = 2;
        $db->code = 'role:add';
        $db->method =  'post';
        $db->path = '/roles/create';
        $db->save();

        $db = new \App\Models\Elements();
        $db->name = '修改角色';
        $db->router_id = 2;
        $db->code = 'role:edit';
        $db->method =  'put';
        $db->path = '/roles/{*}/update';
        $db->save();

        $db = new \App\Models\Elements();
        $db->name = '删除角色';
        $db->router_id = 2;
        $db->code = 'role:delete';
        $db->method =  'delete';
        $db->path = '/roles/{*}/delete';
        $db->save();

        $db = new \App\Models\Elements();
        $db->name = '角色详情';
        $db->router_id = 2;
        $db->code = 'role:detail';
        $db->method =  'get';
        $db->path = '/roles/{*}/detail';
        $db->save();
    }
}
