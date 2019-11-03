<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class AdminController extends ApiController
{
    public function lists(){
        $users = Admin::name(request('name'))->email(request('email'))->paginate(10);
        return $this->json_response($users,'操作成功',self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }
}
