<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

$routesFactory = $app['controllers_factory'];
$routesFactory->match('/', function () use ($app) {
    return new RedirectResponse('https://medium.com/continuouspipe');
})->method('GET')->bind('blog');

$routesFactory->match('/{slug}', function ($slug) use ($app) {
    if ('continuouspipe-launches-tool-for-faster-development-workflows' == $slug) {
        $url = 'https://medium.com/continuouspipe/continuouspipe-launches-tool-for-faster-development-workflows-79836b6eb433';
    } else if ('php-uk-gets-exclusive-first-look-at-continuouspipe' == $slug) {
        $url = 'https://medium.com/continuouspipe/php-uk-gets-exclusive-first-look-at-continuouspipe-321135fea81f';
    } else {
        return $app->abort(404);
    }

    return new RedirectResponse($url);
})->method('GET')->bind('blog-single-post');

return $routesFactory;
