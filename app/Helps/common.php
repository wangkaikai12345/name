<?php

if (!function_exists('random_appid')) {

    function random_appid()
    {
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
}

// http格式化
if (!function_exists('http_format')) {

    function http_format($value)
    {
        if (preg_match("/^http?:\\/\\/.+/", $value) || preg_match("/^https?:\\/\\/.+/", $value)) {
            return $value;
        } else {
            return 'http://' . $value;
        }
    }
}

