<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateRoleRequest extends Request
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
        // dd($this->input());
        return [
            'name'          => 'required|max:30',
            'label'         => 'required|max:255',
            'permissions.*.id'    => 'integer|exists:permissions,id'
        ];
    }
}
