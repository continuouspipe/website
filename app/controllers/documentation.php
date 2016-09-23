<?php

$routesFactory = $app['controllers_factory'];
$routesFactory->match('/', function () use ($app) {
    return $app['twig']->render('documentation/basics/index.html.twig');
})->method('GET')->bind('documentation');

$routesFactory->match('/configure/', function () use ($app) {
    return $app['twig']->render('documentation/configure/index.html.twig');
})->method('GET')->bind('documentation_configure');

return $routesFactory;
