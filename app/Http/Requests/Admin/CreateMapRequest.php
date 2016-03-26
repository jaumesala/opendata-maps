<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateMapRequest extends Request
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
            'status'        => 'required|in:public,private,disabled',
            'description'   => 'sometimes|string',
            'tags'          => 'required',
            'style'         => 'required|string',
            'zoom'          => 'required|numeric',
            'longitude'     => 'required|numeric',
            'latitude'      => 'required|numeric',
            'pitch'         => 'required|numeric',
            'bearing'       => 'required|numeric',
        ];
    }
}
