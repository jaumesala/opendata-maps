<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    /**
     * @return collection
     */
    public function getAllByGroupOrdered()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();
        $settings = $settings->groupBY('group');
        return $settings;
    }


    /**
     * @param  string $group
     * @param  array $settings
     * @return bool
     */
    public function updateSettingsByGroup($group = 'general', $settings = [])
    {

        foreach($settings as $setting)
        {
            $model = Setting::whereGroup($group)->whereKey($setting['key'])->first();
            $model->fill(['value' => $setting['value']]);

            if(!$model->save()){
                return false;
            }
        }

        return true;
    }

    /**
     * @param  Request $request
     * @return bool
     */
    public function storeSetting($request)
    {
        $setting = new Setting;

        $setting->group = $request->group;
        $setting->key = $request->key;
        $setting->value = $request->value;

        return $setting->save();
    }


    public function destroySetting($request)
    {
        $result = Setting::destroy($request->id);

        return $result;
    }

}