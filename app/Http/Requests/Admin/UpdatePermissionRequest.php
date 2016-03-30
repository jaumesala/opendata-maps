<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdatePermissionRequest extends Request
{
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
        $id = $this->route('permission');

        return [
            'name'          => 'required|max:30|unique:permissions,name,'.$id,
            'label'         => 'required|max:255'
        ];
    }
}
