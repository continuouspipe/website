<?php

$routes = $app['controllers_factory'];

$routes->get('/quality-assurance-and-collaboration', function() use ($app) {
    return $app['twig']->render('features/quality-assurance-and-collaboration.html.twig');
})->bind('area_qa');

$routes->get('/production-workloads', function() use ($app) {
    return $app['twig']->render('features/production-workloads.html.twig');
})->bind('area_prod');

$routes->get('/developer-environments', function() use ($app) {
    return $app['twig']->render('features/developer-environments.html.twig');
})->bind('area_dev');

return $routes;
