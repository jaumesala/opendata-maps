<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateSettingsRequest extends Request
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

        $group = $this->request->get('group');

        return [
            'group'             => 'required|string|exists:settings,group',
            'settings.*.key'    => 'required|string|exists:settings,key,group,'.$group,
            'settings.*.value'  => 'required|string',
        ];
    }
}
