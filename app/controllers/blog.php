<?php

use Contentful\ResourceNotFoundException;

$routesFactory = $app['controllers_factory'];
$routesFactory->match('/', function () use ($app) {
    if ($tagName = $app['request']->query->get('tag')) {
        $tag = $app['tags']->getSingleTagByName($tagName);
    }

    $posts = $app['post']->getBlogPosts(isset($tag) ? $tag : null);

    return $app['twig']->render('blog/listing.html.twig', [
        'posts' => $posts
    ]);
})->method('GET')->bind('blog');

$routesFactory->match('/{slug}', function ($slug) use ($app) {
    try {
        $post = $app['post']->getSingleBlogPost($slug);
    } catch (ResourceNotFoundException $e) {
        return $app->abort(404);
    }

    return $app['twig']->render('blog/view.html.twig', [
        'post' => $post
    ]);
})->method('GET')->bind('blog-single-post');

return $routesFactory;
