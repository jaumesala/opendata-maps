<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateRoleRequest extends Request
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
        $id = $this->route('user');

        return [
            'name'          => 'required|max:30',
            'label'         => 'required|max:255',
            'permissions.*.id'    => 'integer|exists:permissions,id'
        ];
    }
}
