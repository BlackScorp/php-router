<?php
$router = new Router();

$router->register('/',[IndexController::class]);

$router->register('/profile/{id}',[ProfileController::class]);

$router->register('/account/login',function (Request $request){
return 'Login';
},'POST');


return $router;