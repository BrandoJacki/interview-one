<?php

class  ApiHandler extends ApiCache implements ApiInterface {
    private static $_things = array('task');
    private static $_thing;
    private static $_data;
    private static $_verb;

    public function __construct($request) {
        self::$_verb = $request->getMethod();
        if (self::$_verb === "POST") {
            self::$_data = $request->getParsedBody();
            self::$_thing = $request->getUri()->getPath();
        } else if (self::$_verb === "GET") {
            self::$_data = $request->getQueryParams();
            $parr = explode($request->getUri()->getPath(), '/');
            self::$_thing= $parr[0];
        }
    }  

    public function processRequest() {
        $request = array (
            "verb" => self::$_verb,
            "resource" => self::$_thing,
            "data" => self::$_data,
        );
        
        $cache_key = sha1(json_encode($request));
        if ($this->ifExist($cache_key)) {
            return $this->getData($cache_key);
        }

        $result = self::$_thing::getInstance()
                    ->setVerb(self::$_verb)
                    ->setData(self::$_data)
                    ->run(); 

        $this->setData($cache_key, $result);

        return $result;
    }

    public function isValidRequest() {
        if (in_array(self::$_thing, self::$_things)) {
            return true;
        }

        return false;
    }

}

