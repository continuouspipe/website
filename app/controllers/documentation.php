<?php

$routesFactory = $app['controllers_factory'];
$routesFactory->match('/', function () use ($app) {
    return $app['twig']->render('documentation/basics/introduction.html.twig');
})->method('GET')->bind('documentation');

$routesFactory->match('/basics/{page}/', function ($page) use ($app) {
    return $app['twig']->render('documentation/basics/'.$page.'.html.twig');
})->method('GET')->bind('documentation_basics');

$routesFactory->match('/configure/{page}/', function ($page) use ($app) {
    return $app['twig']->render('documentation/configure/' . $page . '.html.twig');
})->method('GET')->bind('documentation_configure');

$routesFactory->match('/examples/{page}/', function ($page) use ($app) {
    return $app['twig']->render('documentation/examples/' . $page . '.html.twig');
})->method('GET')->bind('documentation_examples');

return $routesFactory;
