<?php

$routes = $app['controllers_factory'];
$routes->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', [

    ]);
});

return $routes;
