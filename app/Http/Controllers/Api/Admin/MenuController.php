<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class MenuController extends ApiController
{
    public function lists()
    {
        $menus = Menu::name(request('name'))->paginate(10);
        return $this->json_response($menus, '操作成功', self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }

    public function all(){
        $menus = Menu::name(request('name'))->get();
        return $this->json_response(make_tree($menus->toArray()), '操作成功', self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }

    public function detail($id)
    {
        if (is_null($id)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $detail = Menu::find($id);
        return $this->json_response($detail, '操作成功', self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }

    public function update($id)
    {
        $admin = Menu::where('id', $id)->first();
        try {
            if (is_null($admin)) {
                return $this->json_response(null, '用户不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
            }
            if (Menu::checkUnique()) {
                $admin->update(request_intersect([
                    'role_id', 'name', 'email', 'password'
                ]));
            } else {
                return $this->json_response(null, '该用户已存在，请更换用户名或登录邮箱', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function create()
    {
        $admin = new Menu();
        try {
            if (Menu::checkUnique()) {
                $data = request_intersect([
                    'role_id', 'name', 'email', 'password'
                ]);
                $data['password'] = Hash::make($data['password']);
                $data['api_token'] = (string)Str::uuid();
                $data['avatar'] = 'images/avatar.png';
                $admin->create($data);
            } else {
                return $this->json_response(null, '该用户已存在，请更换用户名或邮箱', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function delete($id)
    {
        $menu = Menu::find($id);
        if ($id == 1) return $this->json_response(null, '该菜单不存在', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        if (is_null($menu)) {
            return $this->json_response(null, '菜单不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
        } else {
            $menu->delete();
            return $this->json_response();
        }
    }
}
