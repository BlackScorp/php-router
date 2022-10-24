<?php
error_reporting(E_ALL);

require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Request.php';

$router = require_once __DIR__ . '/routes.php';

$request = Request::createFromGlobal();

try{
    echo $router->handle($request);
}catch (RouteNotFoundException $exception){
    echo $exception->getMessage();
}
