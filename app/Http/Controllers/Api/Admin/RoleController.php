<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends ApiController
{
    public function lists(){
        $page = request('limit', 20);
        $roles = Role::name(request('name'))->alias(request('alias'))->paginate($page);
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
        try{
            if(is_null($role)){
                return $this->json_response(null,'角色不存在',self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
            }
            if(Role::checkUnique()){
                $role->update(request_intersect([
                    'name', 'alias'
                ]));
            }else{
                return $this->json_response(null,'该角色名已存在',self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }

        }catch (\Exception $exception){
            Log::error($exception);
            return $this->json_response(null,'系统错误',self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function create(){
        $role = new Role();
        try{
            if(Role::checkUnique()){
                $role->create(request_intersect([
                    'name', 'alias'
                ]));
            }else{
                return $this->json_response(null,'该角色已存在，请更换角色名或别名',self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }

        }catch (\Exception $exception){
            Log::error($exception);
            return $this->json_response(null,'系统错误',self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }
}
