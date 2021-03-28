<?php

class WebAPI{
    private static $_instance = null;
    private static $_request;

    private function __clone() {}   

    private function __construct($request) {
        self::$_request = $request;
    }  

    public static function &getInstance($request): ApiHandler {
        if ( !(self::$_instance instanceof self) && is_null(self::$_instance) ) {
            self::$_instance = new ApiHandler($request);
        }

        return self::$_instance;
    }
}