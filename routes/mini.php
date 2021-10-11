<?php

use Illuminate\Routing\Router;

/**
 * @var Router $router
 */
$router->group([
    'middleware' => 'auth.mini'
], function (Router $router) {

});
