<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

$routesFactory = $app['controllers_factory'];
$routesFactory->match('/{anything}', function () use ($app) {
    return new RedirectResponse('https://docs.continuouspipe.io');
})->method('GET')->bind('documentation')->assert('anything', '.*');

return $routesFactory;
