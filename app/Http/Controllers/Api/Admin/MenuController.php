<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MenuController extends ApiController {
    public function lists() {
        $page = request('limit', 20);
        $menus = Menu::name(request('name'))->paginate($page);
        return $this->json_response($menus);
    }

    public function all() {
        $menus = Menu::orderBy('order_num', 'asc')->get();
        return $this->json_response(make_tree($menus->toArray()));
    }

    public function allWithElements(){
        $menu = Menu::orderBy('order_num', 'asc')->with('elements')->get();
        return $this->json_response($menu);
    }

    public function parents() {
        $menus = Menu::where('parent_id', 0)->get();
        return $this->json_response($menus);
    }

    public function detail($id) {
        if (is_null($id)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $detail = Menu::find($id);
        return $this->json_response($detail);
    }

    public function update($id) {
        $menu = Menu::where('id', $id)->first();
        try {
            if (is_null($menu)) {
                return $this->json_response(null, '该菜单不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
            }
            $data = request_intersect([
                'parent_id', 'name', 'title', 'path', 'icon', 'component', 'redirect', 'order', 'hidden'
            ]);
            $menu->update($data);
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function create() {
        $model = new Menu();
        try {
            $data = request_intersect([
                'parent_id', 'name', 'title', 'path', 'icon', 'component', 'redirect', 'order', 'hidden'
            ]);
            $data['icon'] = is_null($data['icon']) ? 'smile' : $data['icon'];
            $menu = $model->firstOrCreate($data);
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response($menu);
    }

    public function delete($id) {
        $menu = Menu::find($id);
        if ($id == 1) return $this->json_response(null, '该菜单不可删除', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);

        $has_children = Menu::where('parent_id', $id)->first();
        if (!is_null($has_children)) return $this->json_response(null, '请先删除该菜单下的子菜单', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);

        if (is_null($menu)) {
            return $this->json_response(null, '菜单不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
        } else {
            $menu->delete();
            return $this->json_response();
        }
    }
}
