<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
    public function lists(){
        $users = Role::name(request('name'))->alias(request('alias'))->paginate(10);
        return $this->json_response($users,'操作成功',self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }
}
