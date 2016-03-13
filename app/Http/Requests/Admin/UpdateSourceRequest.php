<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateSourceRequest extends Request
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
            'name'          => 'required|max:255',
            'description'   => 'sometimes|string',
            'web'           => 'sometimes|url',
            'sync_interval' => 'required|in:never,yearly,monthly,weekly,daily,onchange',
        ];
    }
}
