<?php

namespace Qwoot\FormType;

use Generic\FormType\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class QuoteFormType implements FormTypeInterface
{
    /** @var \Symfony\Component\Form\FormFactory */
    private $formFactory;

    /**
     * @param \Symfony\Component\Form\FormFactory $formFactory
     */
    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * Set form properties, types and constraints.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function buildForm()
    {
        return $this->formFactory->createNamedBuilder('', FormType::class)
            ->add(
                'datetime',
                TextType::class,
                array(
                    'empty_data' => date('Y-m-d H:i:s'),
                )
            )
            ->add('context', TextType::class)
            ->add(
                'quote',
                TextType::class,
                array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5))),
                )
            )
            ->add(
                'user',
                TextType::class,
                array(
                    'property_path' => '[user_id]',
                )
            )
            ->add(
                'person',
                TextType::class,
                array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2))),
                )
            )
            ->getForm();
    }
}
