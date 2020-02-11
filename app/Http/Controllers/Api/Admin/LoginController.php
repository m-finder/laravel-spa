<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Admin;
use App\Models\Code;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{

    public function login()
    {
        $password = request('password');
        $admin = Admin::query()->where('email', request('email'))->first();

        if (is_null($admin)) {
            return $this->error('用户不存在。');
        }
        if (!Hash::check($password, $admin->password)) {
            return $this->error('用户密码错误。');
        }
        return $this->success($admin);
    }


}
