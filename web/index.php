<?php

use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine;
use Contentful\Delivery\Client;
use Inviqa\Blog\Post;
use Inviqa\Blog\QueryFactory;
use Inviqa\Blog\Tag;
use Ramsey\Twig\CodeBlock\TokenParser\CodeBlockParser;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application([
    'debug' => getenv('DEBUG_MODE'),
]);
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views',
));

$app['twig'] = $app->share($app->extend('twig', function(\Twig_Environment $twig, $app) {
    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
        return $app['request']->getBasePath().$asset;
    }));
    $twig->addExtension(new Twig_Extensions_Extension_Text());

    $engine = new MarkdownEngine\MichelfMarkdownEngine();
    $twig->addExtension(new MarkdownExtension($engine));

    $twig->addTokenParser(new CodeBlockParser('pygments', []));

    return $twig;
}));

$app['contentfulClient'] = $app->share(function ($app) {
    return new Client(getenv('CONTENTFUL_ACCESS_TOKEN'), getenv('CONTENTFUL_SPACE_ID'));
});

$app['post'] = $app->share(function ($app) {
    return new Post($app['contentfulClient'], new QueryFactory(), getenv('CONTENTFUL_POST_CONTENT_TYPE'));
});

$app['tags'] = $app->share(function ($app) {
    return new Tag($app['contentfulClient'], new QueryFactory(), getenv('CONTENTFUL_TAG_CONTENT_TYPE'));
});

$app->mount('/', require '../app/controllers/home.php');
$app->mount('/docs/', require '../app/controllers/documentation.php');
$app->mount('/blog/', require '../app/controllers/blog.php');
$app->mount('/features/', require '../app/controllers/features.php');
$app->run();
