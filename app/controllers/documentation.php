<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

$routesFactory = $app['controllers_factory'];
$routesFactory->match('/{anything}', function () use ($app) {
    return new RedirectResponse('https://documentation-continuouspipe.github.io');
})->method('GET')->bind('documentation')->assert('anything', '.*');

return $routesFactory;
