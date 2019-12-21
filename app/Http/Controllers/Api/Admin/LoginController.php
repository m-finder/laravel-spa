<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    public function login(){
        $email = request('email');
        $password = request('password');
        $admin = Admin::where('email', $email)->first();
        if(is_null($admin)){
            return $this->error('用户不存在。');
        }
        if(Hash::check($password, $admin->password)){
            return $this->success($admin);
        }else{
            return $this->error('用户密码错误。');
        }
    }
}
