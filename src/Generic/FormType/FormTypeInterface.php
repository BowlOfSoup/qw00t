<?php

namespace Generic\FormType;

interface FormTypeInterface
{
    /**
     * Set form properties, types and constraints.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function buildForm();
}
