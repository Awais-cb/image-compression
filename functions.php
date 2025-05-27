<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!function_exists('dd')) {
    function dd($d)
    {
        die('<pre>' . print_r($d, 1) . '</pre>');
    }
}

if (!function_exists('p')) {
    function p($d, $log = true)
    {
        if ($log) {
            error_log(print_r($d, 1));
        }
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }
}