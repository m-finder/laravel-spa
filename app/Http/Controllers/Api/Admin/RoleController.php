<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Role;
use App\Models\RoleElement;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends ApiController
{
    public function lists()
    {
        $page = request('limit', 20);
        $roles = Role::name()->alias()->paginate($page);
        return $this->success($roles);
    }

    public function all()
    {
        $roles = Role::get();
        return $this->success($roles);
    }

    public function auth($id)
    {
        Role::findOrFail($id);
        $menus = RolePermission::select('permission_id')->where('role_id', $id)->get()->toArray();
        $elements = RoleElement::select('element_id')->where('role_id', $id)->get()->toArray();
        return $this->success([
            'menus' => array_column($menus, 'permission_id'),
            'elements' => array_column($elements, 'element_id')
        ]);
    }

    public function setAuth($id)
    {
        Role::findOrFail($id);
        $menus = request('menus');
        $elements = request('elements');

        try {
            DB::transaction(function () use ($id, $menus, $elements) {
                # 清空原数据
                RolePermission::where('role_id', $id)->delete();
                RoleElement::where('role_id', $id)->delete();

                # 菜单整理
                $menu_filter = ['role_id', 'permission_id'];
                array_walk($menus, function (&$value) use ($id, $menu_filter) {
                    $value = array_combine($menu_filter, [$id, $value]);
                });

                # 资源整理
                $element_filter = ['role_id', 'element_id'];
                array_walk($elements, function (&$value) use ($id, $element_filter) {
                    $value = array_combine($element_filter, [$id, $value]);
                });
                RolePermission::insert($menus);
                RoleElement::insert($elements);
            });

            return $this->success();
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->error('系统错误。');
        }
    }

    public function detail($id)
    {
        $detail = Role::findOrFail($id);
        return $this->success($detail);
    }

    public function update($id)
    {
        $role = Role::findOrFail($id);
        if (Role::checkUnique()) {
            $role->update(request_intersect([
                'name', 'alias'
            ]));
        } else {
            return $this->error('该角色已存在，请更换角色名或别名');
        }
        return $this->success();
    }

    public function create()
    {
        $role = new Role();
        if (Role::checkUnique()) {
            $role->create(request_intersect([
                'name', 'alias'
            ]));
        } else {
            return $this->error('该角色已存在，请更换角色名或别名');
        }
        return $this->success();
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        if ($id == 1) return $this->error('该角色内置，不可删除');
        $role->delete();
        return $this->success();
    }
}
