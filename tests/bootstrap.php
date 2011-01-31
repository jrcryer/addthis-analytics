<?php
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('LIB_PATH', BASE_PATH . '/lib/');

array_walk(scandir(LIB_PATH), function($filename) {
    if(preg_match('/\.php$/i', $filename)) {
        require_once(LIB_PATH.$filename);
    }
});