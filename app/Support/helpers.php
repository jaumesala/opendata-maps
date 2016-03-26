<?php

if (! function_exists('ts_diffHumans')) {
    /**
     * Returns a human readable difference of a timestamp.
     *
     * @param  string  $timestamp
     * @return string
     */
    function ts_diffForHumans($timestamp)
    {
        $date       = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
        return $date->diffForHumans();
    }
}


if (! function_exists('number_sizeFormat')) {
    /**
     * Returns a human readable computer file size.
     *
     * @param  int  $number
     * @return string
     */
    function number_sizeFormat($number)
    {
        $precision = 2;
        $base = log($number, 1024);
        $suffixes = array('b', 'Kb', 'Mb', 'Gb', 'Tb');
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}


if (! function_exists('setting_value')) {
    /**
     * Returns the value for a given group name and key.
     *
     * @param  string  $group
     * @param  string  $key
     * @return string
     */
    function setting_value($group, $key)
    {
        if( ! \Cache::has('settings') ) return null;
        $cache = \Cache::get('settings');
        if( ! $cache->has($group) ) return null;
        $groupCache = $cache[$group];
        if( ! array_key_exists($key, $groupCache) ) return null;
        return $groupCache[$key];
    }
}
