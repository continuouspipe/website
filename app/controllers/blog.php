<?php

use Contentful\ResourceNotFoundException;

$routesFactory = $app['controllers_factory'];
$routesFactory->match('/', function () use ($app) {
    $posts = $app['blog']->getBlogPosts();

    return $app['twig']->render('blog/listing.html.twig', [
        'posts' => $posts
    ]);
})->method('GET')->bind('blog-listing');

$routesFactory->match('/{slug}', function ($slug) use ($app) {
    try {
        $post = $app['blog']->getSingleBlogPost($slug);
    } catch (ResourceNotFoundException $e) {
        return $app->abort(404);
    }

    return $app['twig']->render('blog/view.html.twig', [
        'post' => $post
    ]);
})->method('GET')->bind('blog-single-post');

return $routesFactory;