<?php

use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application([
    'debug' => true,
]);
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views',
));

$app->mount('/', require '../app/controllers/home.php');
$app->run();
