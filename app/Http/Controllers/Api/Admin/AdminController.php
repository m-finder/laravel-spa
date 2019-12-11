<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminController extends ApiController {
    public function lists() {
        $users = Admin::name(request('name'))->email(request('email'))->with('role')->paginate(10);
        return $this->json_response($users);
    }

    public function detail($id) {
        if (is_null($id)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $detail = Admin::find($id);
        return $this->json_response($detail);
    }

    public function update($id) {
        $admin = Admin::where('id', $id)->first();
        try {
            if (is_null($admin)) {
                return $this->json_response(null, '用户不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
            }
            if (Admin::checkUnique()) {
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

    public function create() {
        $admin = new Admin();
        try {
            if (Admin::checkUnique()) {
                $data = request_intersect([
                    'role_id', 'name', 'email', 'password'
                ]);
                $data['password'] = Hash::make($data['password']);
                $data['api_token'] = (string)Str::uuid();
                $data['avatar'] = 'images/avatar.jpg';
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

    public function delete($id) {
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
