<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class DestroySettingRequest extends Request
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
        return [
            'id'            =>'required|integer|exists:settings,id',
            'confirmation'  => 'required|accepted',
        ];
    }
}
