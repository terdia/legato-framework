<?php

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router){
    $router->addRoute('GET', '/', 'Legato\Framework\Controllers\IndexController@show');
});

return $dispatcher;