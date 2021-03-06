<?php

use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Intercom\IntercomClient;

$routes = $app['controllers_factory'];
$routes->match('/contact', function (Request $request) use ($app) {
    /** @var FormFactoryInterface $formFactory */
    $formFactory = $app['form.factory'];

    /** @var FormInterface $form */
    $form = $formFactory->createBuilder(FormType::class, null, ['csrf_protection' => false])
        ->add('name', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'What\'s your name?',
                ]),
            ],
            'attr' => [
                'placeholder' => 'Your name',
            ],
        ])
        ->add('email', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'If you don\'t give us an email address we won\'t be able to answer your message!',
                ]),
                new Email([
                    'message' => 'The email address should be valid'
                ]),
            ],
            'attr' => [
                'placeholder' => 'Your email address',
            ],
        ])
        ->add('company', TextType::class, [
            'required' => false,
            'attr' => [
                'placeholder' => 'Your company',
            ],
        ])
        ->add('message', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Your message',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'I\'m not sure if we\'ll really be able to help you if you don\'t say anything to us!',
                ]),
            ],
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $formData = $form->getData();

        $client = new IntercomClient('i0yqsxbt', '425c0c2f4a693ec048e1496cd4169b59071d6ae9');

        try {
            $response = $client->leads->getLeads([
                'email' => $formData['email'],
            ]);

            $leadsWithThisEmail = $response->contacts;

            if (count($leadsWithThisEmail) > 0) {
                $lead = current($leadsWithThisEmail);
            } else {
                $lead = $client->leads->create([
                    'email' => $formData['email'],
                    'name' => $formData['name'],
                    'custom_attributes' => [
                        'company' => (string) $formData['company'],
                    ]
                ]);
            }

            $client->messages->create([
                'from' => [
                    'type' => 'contact',
                    'id' => $lead->id,
                ],
                'body' => $formData['message'],
            ]);

            $message = 'Thank you very much, we will get in touch soon!';
        } catch (ClientException $e) {
            echo $e->getResponse()->getBody()->getContents();
            $form->addError(new FormError($e->getMessage()));
        }
    }

    return $app['twig']->render('contact.html.twig', [
        'form' => $form->createView(),
        'data' => $form->getData(),
        'timestamp' => time(),
        'message' => isset($message) ? $message : null,
    ]);
})->method('GET|POST')->bind('contact');

$routes->get('/pricing', function() use ($app) {
    return $app['twig']->render('pricing.html.twig');
})->bind('pricing');

$routes->get('/frequently-asked-questions', function() use ($app) {
    return new RedirectResponse('https://continuouspipe.github.io/docs/faq/#from-website');
})->bind('faq');

$routes->get('/why', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('homepage').'#why');
})->bind('why');

$routes->get('/services', function() use ($app) {
    return new RedirectResponse($app['url_generator']->generate('contact').'#services');
})->bind('services');

$routes->get('/get-started', function() use ($app) {
    return new RedirectResponse('https://continuouspipe.github.io/docs/guides/#from-website');
})->bind('get-started');

$routes->get('/terms-and-conditions', function() use ($app) {
    return $app['twig']->render('terms-and-conditions.html.twig');
})->bind('terms-and-conditions');

$routes->get('/', function() use ($app) {
    return $app['twig']->render('home.html.twig');
})->bind('homepage');

$app->error(function (\Exception $e, $code) use ($app) {
    return $app['twig']->render('exception/error.html.twig',[
         'code' => $code,
    ]);
});

return $routes;
