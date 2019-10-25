<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(){
        $email = request('email');
        $password = request('password');
        $admin = Admin::where('email', $email)->first();
        if(is_null($admin)){
            return $this->json_response(null,'用户不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
        }
        if(Hash::check($password, $admin->password)){
            return $this->json_response($admin->token , '欢迎回来');
        }else{
            return $this->json_response(null,'用户密码错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
    }
}