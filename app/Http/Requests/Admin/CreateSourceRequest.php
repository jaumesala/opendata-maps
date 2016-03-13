<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateSourceRequest extends Request
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
            'origin_type'   => 'required|in:url,file,dropbox,gdrive',
            'origin_url'    => 'required|url|max:2048',
            'name'          => 'required|max:255',
            'description'   => 'sometimes|string',
            'web'           => 'sometimes|url',
            'sync_interval' => 'required|in:never,yearly,monthly,weekly,daily,onchange',
        ];
    }
}
