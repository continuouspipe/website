<?php

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

$routes = $app['controllers_factory'];
$routes->match('/', function (Request $request) use ($app) {
    /** @var FormFactoryInterface $formFactory */
    $formFactory = $app['form.factory'];

    /** @var FormInterface $form */
    $form = $formFactory->createBuilder(FormType::class)
        ->add('email', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Email(),
            ]
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $email = $form->getData()['email'];

        $message = 'Thank you very much, see you soon!';
    }

    return $app['twig']->render('index.html.twig', [
        'form' => $form->createView(),
        'message' => isset($message) ? $message : null,
    ]);
})->method('GET|POST');

return $routes;
