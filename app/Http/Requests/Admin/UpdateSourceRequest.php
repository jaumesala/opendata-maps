<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use App\Models\Source;

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
        $id = $this->route('source');
        $source = Source::findOrFail($id);

        $rules = [
            'name'          => 'required|max:255',
            'description'   => 'sometimes|string',
            'web'           => 'sometimes|url',
        ];

        switch($source->origin_type)
        {
            case 'url':
                $typeRules = [
                    'sync_interval' => 'required|in:never,yearly,monthly,weekly,daily,onchange',
                ];
                break;

            case 'file':
                $typeRules = [];
                break;

            default:
                $typeRules = [];
        }

        return array_merge($rules, $typeRules);
    }
}
