<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\RequestErrorMessage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    use RequestErrorMessage;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [

        ];

        switch ($this->method()) {
            case 'POST':
                $rules['name'] = 'required|max:255|unique:roles';
                $rules['alias'] = 'required|max:255|unique:roles';
                break;
            case 'PUT':
                $id = $this->route('id');
                $rules['name'] = [
                    'required',
                    'max:255',
                    Rule::unique('roles')->ignore($id)
                ];
                $rules['alias'] = [
                    'required',
                    'max:255',
                    Rule::unique('roles')->ignore($id)
                ];
                break;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => '角色名称',
            'alias' => '角色别名',
        ];
    }

    public function message()
    {
        return '无效的数据。';
    }
}
