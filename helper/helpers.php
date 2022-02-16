<?php

if (! function_exists('generateUUID')) {
    /**
     * 產生UUID
     *
     * @param string $prefix 使用前綴
     * @param boolean $useHyphen 是否使用分隔
     * @return string 產生好的uuid
     */
    function generateUUID($prefix = "",$useHyphen=false)
    {
        $str = md5(uniqid(mt_rand(), true));  
        
        $hyphen = ($useHyphen)?chr(45):null;
        //$hyphen = null;
        $uuid  = substr($str,0,8) . $hyphen;  
        $uuid .= substr($str,8,4) . $hyphen;  
        $uuid .= substr($str,12,4) . $hyphen;  
        $uuid .= substr($str,16,4) . $hyphen;  
        $uuid .= substr($str,20,12);  
        return $prefix . $uuid;
    }
}
if (! function_exists('validateDate')) {
    /**
     * 驗證日期格式是否合格
     *
     * @param [type] $date 想要認證的日期
     * @return boolean true合格 false不合格
     */
    function validateDate($date)
    {
       return (!strtotime($date))?false:true;
    }
}
if (! function_exists('currentDate')) {
    /**
     * 獲取當前日期
     *
     * @return Carbon實例
     */
    function currentDate()
    {
        return Carbon\Carbon::now();
    }
}

if (! function_exists('getStdClass')) {
    /**
     * 獲得一個空對象
     *
     * @return stdClass實例
     */
    function getStdClass()
    {
        return new STORMSQ\DeveloperService\Classes\stdClass;
    }
}


