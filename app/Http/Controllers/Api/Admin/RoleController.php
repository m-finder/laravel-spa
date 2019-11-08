<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\RoleStoreReuqest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends ApiController
{
    public function lists(){
        $roles = Role::name(request('name'))->alias(request('alias'))->paginate(10);
        return $this->json_response($roles,'操作成功',self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }

    public function detail(){
        $id = request('id');

        if (is_null($id)){
            return $this->json_response(null,'参数错误',self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $detail = Role::findOrFail($id);
        return $this->json_response($detail,'操作成功',self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }

    public function update(){
        $id = request('id');
        $role = Role::where('id',$id)->first();
        if(is_null($role)){
            return $this->json_response(null,'用户不存在',self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
        }
        try{
            $role->update(request_intersect([
                'name', 'alias'
            ]));
        }catch (\Exception $exception){
            Log::error($exception);
            return $this->json_response(null,'系统错误',self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response(null,'操作成功',self::ERROR_NONE, self::MSG_TYPE_SUCCESS);
    }
}
