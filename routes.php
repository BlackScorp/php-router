<?php
require_once __DIR__ . '/IndexController.php';
require_once __DIR__ . '/ProfileController.php';
$router = new Router();


$router->register('/', new IndexController());

$router->register('/profile/{id}', new ProfileController());

$router->register('/account/login', function (Request $request) {
    return 'Login';
}, 'POST');


return $router;