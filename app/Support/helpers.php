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


