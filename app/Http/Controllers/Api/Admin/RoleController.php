<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Role;
use App\Models\RoleElement;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends ApiController {
    public function lists() {
        $page = request('limit', 20);
        $roles = Role::name(request('name'))->alias(request('alias'))->paginate($page);
        return $this->json_response($roles);
    }

    public function all() {
        $roles = Role::get();
        return $this->json_response($roles);
    }

    public function auth($id) {
        if (is_null($id)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $menus = RolePermission::select('permission_id')->where('role_id', $id)->get()->toArray();
        $elements = RoleElement::select('element_id')->where('role_id', $id)->get()->toArray();
        $data = [
            'menus' => array_column($menus, 'permission_id'),
            'elements' => array_column($elements, 'element_id')
        ];
        return $this->json_response($data);
    }

    public function setAuth($id){
        $menus = request('menus');
        $elements = request('elements');
        if (is_null($id) || is_null($menus) || is_null($elements)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        try{
            DB::transaction(function () use ($id, $menus, $elements) {
                # 清空原数据
                RolePermission::where('role_id', $id)->delete();
                RoleElement::where('role_id', $id)->delete();

                # 插入新数据
                $menu_filter = ['role_id', 'permission_id'];
                array_walk($menus, function (&$value) use ($id, $menu_filter) {
                    $value = array_combine($menu_filter, [$id, $value]);
                });

                $element_filter = ['role_id', 'element_id'];
                array_walk($elements, function (&$value) use ($id, $element_filter) {
                    $value = array_combine($element_filter, [$id, $value]);
                });
                RolePermission::insert($menus);
                RoleElement::insert($elements);
            });

            return $this->json_response();
        }catch (\Exception $exception){
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
    }

    public function detail($id) {
        if (is_null($id)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $detail = Role::find($id);
        return $this->json_response($detail);
    }

    public function update($id) {
        $role = Role::where('id', $id)->first();
        try {
            if (is_null($role)) {
                return $this->json_response(null, '角色不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
            }
            if (Role::checkUnique()) {
                $role->update(request_intersect([
                    'name', 'alias'
                ]));
            } else {
                return $this->json_response(null, '该角色已存在，请更换角色名或别名', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function create() {
        $role = new Role();
        try {
            if (Role::checkUnique()) {
                $role->create(request_intersect([
                    'name', 'alias'
                ]));
            } else {
                return $this->json_response(null, '该角色已存在，请更换角色名或别名', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function delete($id) {
        $role = Role::find($id);
        if ($id == 1) return $this->json_response(null, '该角色内置，不可删除', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        if (is_null($role)) {
            return $this->json_response(null, '角色不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
        } else {
            $role->delete();
            return $this->json_response();
        }
    }
}
