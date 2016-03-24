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
        $type = $this->input('origin_type');

        $rules = [
            'origin_type'   => 'required|in:url,file,dropbox,gdrive',
            'name'          => 'required|max:255',
            'description'   => 'sometimes|string',
        ];

        switch($type)
        {
            case 'url':
                $typeRules = [
                    'origin_url'    => 'required|url|max:2048',
                    'web'           => 'sometimes|url',
                    'sync_interval' => 'required|in:never,yearly,monthly,weekly,daily,onchange',
                ];
                break;

            case 'file':
                $typeRules = [
                    'origin_file'    => 'required|mimes:csv,txt,json,geojson,kml,gpx'
                ];
                break;

            default:
                $typeRules = [];
        }

        return array_merge($rules, $typeRules);
    }
}
