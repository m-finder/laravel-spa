<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class AdminController extends ApiController
{
    public function lists()
    {
        $users = Admin::name(request('name'))->email(request('email'))->paginate(10);
        return $this->json_response($users, '操作成功', self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }

    public function detail($id)
    {
        if (is_null($id)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $detail = Admin::find($id);
        return $this->json_response($detail, '操作成功', self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }

    public function update($id)
    {
        $role = Admin::where('id', $id)->first();
        try {
            if (is_null($role)) {
                return $this->json_response(null, '角色不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
            }
            if (Admin::checkUnique()) {
                $role->update(request_intersect([
                    'name', 'alias'
                ]));
            } else {
                return $this->json_response(null, '该角色名已存在', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function create()
    {
        $role = new Admin();
        try {
            if (Admin::checkUnique()) {
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

    public function delete($id)
    {
        $admin = Admin::find($id);
        if ($id == 1) return $this->json_response(null, '该用户内置，不可删除', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        if (is_null($admin)) {
            return $this->json_response(null, '用户不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
        } else {
            $admin->delete();
            return $this->json_response();
        }
    }
}
