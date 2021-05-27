<?php

if (! function_exists('generateUUID')) {
    function generateUUID($prefix = "")
    {
        $str = md5(uniqid(mt_rand(), true));  
        //$hyphen = chr(45);
        $hyphen = null;
        $uuid  = substr($str,0,8) . $hyphen;  
        $uuid .= substr($str,8,4) . $hyphen;  
        $uuid .= substr($str,12,4) . $hyphen;  
        $uuid .= substr($str,16,4) . $hyphen;  
        $uuid .= substr($str,20,12);  
        return $prefix . $uuid;
    }
}
if (! function_exists('validateDate')) {
    function validateDate($date)
    {
       return (!strtotime($date))?false:true;
    }
}
if (! function_exists('currentDate')) {
    function currentDate()
    {
        return Carbon\Carbon::now();
    }
}

