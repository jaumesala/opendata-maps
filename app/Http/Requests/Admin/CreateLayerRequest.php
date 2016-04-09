<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateLayerRequest extends Request
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
            'map_id'        => 'required|integer|exists:maps,id',
            'source_id'     => 'required|integer|exists:sources,id',
            'visible'       => 'required|boolean',
            'opacity'       => 'required|integer',
            'type'          => 'required|in:fill,circle,line',
            'interactive'   => 'required|boolean',
            'minzoom'       => 'required|numeric|min:0|max:22',
            'maxzoom'       => 'required|numeric|min:0|max:22',
            'paint'         => '',
            'filter'        => ''
        ];
    }
}