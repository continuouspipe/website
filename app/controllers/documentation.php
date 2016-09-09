<?php

$routes = $app['controllers_factory'];
$routes->match('/', function () use ($app) {
    return $app['twig']->render('documentation/index.html.twig');
})->method('GET')->bind('documentation');

return $routes;
