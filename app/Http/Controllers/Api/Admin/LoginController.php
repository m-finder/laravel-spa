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
    /**
     * 验证码过期时间
     */
    const CODE_EXPIRED_TIME = 30;

    public function login()
    {
        $password = request('password');
        $admin = Admin::where('email', request('email'))->first();

        if (is_null($admin)) {
            return $this->error('用户不存在。');
        }
        if (!Hash::check($password, $admin->password)) {
            return $this->error('用户密码错误。');
        }
        return $this->success($admin);
    }

    /**
     * 忘记密码
     */
    public function resetPassword()
    {
        $data = request_intersect([
            'email', 'code', 'password'
        ]);

        $code = Code::query()->where('email', $data['email'])
            ->where('is_used', 0)
            ->orderBy('id', 'desc')->first();
        if ($this->isCodeExpired($code)) {
            return $this->error('无效的验证码。');
        }

        if (is_null($admin = Admin::query()->where('email', $data['email'])->first())) {
            return $this->error('无效的邮箱。');
        }

        $admin->update(['password' => Hash::make($data['password'])]);
        $code->update(['is_used' => 1]);
        return $this->success();
    }

    public function isCodeExpired($code = null)
    {
        return is_null($code) || $code->created_at < Carbon::now()->subMinute(self::CODE_EXPIRED_TIME);
    }
}
