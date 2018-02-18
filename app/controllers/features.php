<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

$routes = $app['controllers_factory'];

$routes->get('', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('feature_developers'));
})->bind('features');

$routes->get('/quality-assurance-and-collaboration', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('area_fast_feedback'), RedirectResponse::HTTP_MOVED_PERMANENTLY);
})->bind('area_qa');

$routes->get('/fast-feedback', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('feature_business'), RedirectResponse::HTTP_MOVED_PERMANENTLY);
})->bind('area_fast_feedback');

$routes->get('/production-workloads', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('feature_ops'), RedirectResponse::HTTP_MOVED_PERMANENTLY);
})->bind('area_prod');

$routes->get('/developer-environment', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('feature_developers'), RedirectResponse::HTTP_MOVED_PERMANENTLY);
})->bind('area_dev');

$routes->get('/developers', function() use ($app) {
    return $app['twig']->render('features/developers.html.twig');
})->bind('feature_developers');

$routes->get('/ops', function() use ($app) {
    return $app['twig']->render('features/ops.html.twig');
})->bind('feature_ops');

$routes->get('/business', function() use ($app) {
    return $app['twig']->render('features/business.html.twig');
})->bind('feature_business');

return $routes;
