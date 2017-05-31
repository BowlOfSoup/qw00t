<?php

namespace Qwoot\Controller;

use Qwoot\Service\QuoteService;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

class QuoteController
{
    const ID = 'qwoot.controller.quote_controller';

    /** @var \Qwoot\Service\QuoteService */
    private $quoteService;

    /** @var \Symfony\Component\Form\FormFactory */
    private $formFactory;

    public function __construct(
        QuoteService $quoteService,
        FormFactory $formFactory
    ) {
        $this->quoteService = $quoteService;
        $this->formFactory = $formFactory;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getListAction(Request $request)
    {
        if ($request->get('random')) {
            return new Response(
                json_encode(array('result' => $this->quoteService->findRandom()))
            );
        }

        return new Response(
            json_encode(array('result' => $this->quoteService->findAll()))
        );
    }


    public function createAction(Request $request)
    {
        $form = $this->formFactory->createNamedBuilder('', FormType::class)
            ->add('name', TextType::class, array(
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
            ))
            ->add('quote')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
//            $data = $form->getData();

            var_dump('valid');
        } else {
            foreach ($form->getErrors(true) as $error) {
                var_dump($error->getOrigin()->getName());
                var_dump($error->getMessage());
            }
        }

        return new Response(
            json_encode(array('result' => array()))
        );
    }
}
