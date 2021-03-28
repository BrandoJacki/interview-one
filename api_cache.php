<?php

class ApiCache {
    private static $_cache = array();

    private function ifExist($key) {
        if (in_array($key, self::$_cache)) {
            return true;
        } else {
            self::$_cache[$key] = "";
            return false;
        }
    }

    private function getData($key) {
        return self::$_cache[$key];
    }   
    
    private function setData($key, $data) {
        self::$_cache[$key] = $data;
    }   
}

