<?php

namespace Security\FormType;

use Generic\FormType\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class UserFormType implements FormTypeInterface
{
    const PROPERTY_PASSWORD = 'password';

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
                'userName',
                TextType::class,
                array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2))),
                    'property_path' => '[username]',
                )
            )
            ->add(
                'password',
                PasswordType::class,
                array(
                    'constraints' => array(new Assert\NotBlank()),
                )
            )
            ->add(
                'name',
                TextType::class,
                array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2))),
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'constraints' => array(new Assert\Email()),
                )
            )
            ->getForm();
    }
}
