<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Element;
use App\Models\Menu;
use App\Models\RoleElement;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminController extends ApiController
{

    public function lists()
    {
        $page = request('limit', 20);
        $users = Admin::query()->name(request('name'))->email(request('email'))->with('role')->paginate($page);
        return $this->success($users);
    }

    public function adminAuth()
    {
        $admin = Auth::user();

        $role_menus = RolePermission::query()->select('permission_id')->where('role_id', $admin->role_id)->get()->toArray();
        $role_elements = RoleElement::query()->select('element_id')->where('role_id', $admin->role_id)->get()->toArray();

        $menus = Menu::query()->whereIn('id', array_column($role_menus, 'permission_id'))->get();
        $elements = Element::query()->whereIn('id', array_column($role_elements, 'element_id'))->get();

        return $this->success([
            'menus' => make_tree($menus->toArray()),
            'elements' => $elements
        ]);
    }

    public function detail($id)
    {
        $detail = Admin::query()->findOrFail($id);
        return $this->success($detail);
    }

    public function update(AdminRequest $request, $id)
    {
        $admin = Admin::query()->findOrFail($id);
        $data = request_intersect([
            'role_id', 'name', 'email'
        ]);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $admin->update($data);
        return $this->success();
    }

    public function create(AdminRequest $request)
    {
        $admin = new Admin();
        $data = request_intersect([
            'role_id', 'name', 'email', 'password'
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = (string)Str::uuid();
        $data['avatar'] = 'images/avatar.jpg';
        $admin->query()->create($data);
        return $this->success();
    }

    public function delete($id)
    {
        $admin = Admin::query()->findOrFail($id);
        if ($id == 1) return $this->error('该用户内置，不可删除。');
        $admin->delete();
        return $this->success();
    }
}
