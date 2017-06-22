<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

$routes = $app['controllers_factory'];

$routes->get('', function() use ($app) {
    return $app['twig']->render('features/list.html.twig');
})->bind('features');

$routes->get('/quality-assurance-and-collaboration', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('area_fast_feedback'));
})->bind('area_qa');

$routes->get('/fast-feedback', function() use ($app) {
    return $app['twig']->render('features/fast-feedback.html.twig');
})->bind('area_fast_feedback');

$routes->get('/production-workloads', function() use ($app) {
    return $app['twig']->render('features/production-workloads.html.twig');
})->bind('area_prod');

$routes->get('/developer-environment', function() use ($app) {
    return $app['twig']->render('features/developer-environment.html.twig');
})->bind('area_dev');

return $routes;
