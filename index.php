<?php
// composer require react/http
// composer require react/mysql
require 'autoload.php';

use React\Http\Response;

$loop = \React\EventLoop\Factory::create();

$server = new Server(function (Request $request) {

    $web_api = WebAPI::getInstance($request);
    if (!$web_api->isValidRequest()) {
        $result = "Bad request!";
        $http_status_code = 400;
    } else {
        $result = $web_api->processRequest();
        $http_status_code = 200;
    }    

    return new Response(
        $http_status_code, 
        ['Content-Type' => 'application/json'],
        json_encode($result)
    );
});


$socket = new \React\Socket\Server(
    '127.0.0.1:8000', $loop
);
$server->listen($socket);
$loop->run();




