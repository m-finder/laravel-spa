<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Mail\AdminResetPassword;
use App\Models\Admin;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends ApiController
{
    const RESET_PASSWORD = 0;

    public function resetPassword(){
        $email = request('email');
        $code = rand(100000, 999999);
       try{
           if(Admin::where('email', $email)->firstOrFail()){
               Code::create([
                   'email' => $email,
                   'code' => $code,
                   'type' => self::RESET_PASSWORD
               ]);
           }
           Mail::to($email)->send(new AdminResetPassword($code));
           return $this->success();
       }catch (\Exception $exception){
           Log::error($exception);
           return $this->error('邮件发送失败，请检查邮件配置和目标邮箱是否正确。');
       }

    }
}
