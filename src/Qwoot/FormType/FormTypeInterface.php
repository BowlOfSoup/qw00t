<?php

namespace Qwoot\FormType;

interface FormTypeInterface
{
    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function buildForm();
}
