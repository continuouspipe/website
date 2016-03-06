<?php

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use ZfrMailChimp\Client\MailChimpClient;

$routes = $app['controllers_factory'];
$routes->match('/', function (Request $request) use ($app) {
    /** @var FormFactoryInterface $formFactory */
    $formFactory = $app['form.factory'];

    /** @var FormInterface $form */
    $form = $formFactory->createBuilder(FormType::class)
        ->add('email', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'The email address is required',
                ]),
                new Email([
                    'message' => 'The email address should be valid'
                ]),
            ],
            'attr' => [
                'placeholder' => 'Your email address',
            ],
        ])
        ->add('github', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'The GitHub username is required',
                ]),
            ],
            'attr' => [
                'placeholder' => 'Your GitHub username',
            ],
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $formData = $form->getData();

        $email = $formData['email'];
        $client = new MailChimpClient('b8453108d758fb6feef42cdb90195868-us12');

        try {
            $client->subscribe([
                'id' => '713f4777b9',
                'email' => [
                    'email' => $email
                ],
                'double_optin' => false,
                'send_welcome' => false,
                'merge_vars' => [
                    'github' => $formData['github']
                ]
            ]);

            $message = 'Thank you very much, see you soon!';
        } catch (\ZfrMailChimp\Exception\Ls\AlreadySubscribedException $e) {
            $message = 'Yeah, it looks like you\'ve already subscribed. Thank you again :)';
        } catch (\ZfrMailChimp\Exception\ExceptionInterface $e) {
            $form->addError(new FormError($e->getMessage()));
        }
    }

    return $app['twig']->render('index.html.twig', [
        'form' => $form->createView(),
        'message' => isset($message) ? $message : null,
    ]);
})->method('GET|POST');

return $routes;
