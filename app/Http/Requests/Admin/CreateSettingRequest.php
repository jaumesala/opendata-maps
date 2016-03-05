<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateSettingRequest extends Request
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
        // dd($this->request);
        $group  = $this->request->get('group');
        $key    = $this->request->get('key');

        return [
            'group' => 'required|string|unique:settings,group,NULL,id,key,'.$key,
            'key'   => 'required|string|unique:settings,key,NULL,id,group,'.$group,
            'value' => 'required|string',
        ];
    }
}
