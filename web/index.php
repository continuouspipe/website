<?php

use Ramsey\Twig\CodeBlock\TokenParser\CodeBlockParser;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application([
    'debug' => true,
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

    $twig->addTokenParser(new CodeBlockParser('pygments', []));

    return $twig;
}));


$app->mount('/', require '../app/controllers/home.php');
$app->mount('/docs/', require '../app/controllers/documentation.php');
$app->run();
