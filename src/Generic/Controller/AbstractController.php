<?php

namespace Generic\Controller;

use Generic\Service\MetaService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    const STATUS_UNPROCESSABLE = 422;
    const WRAPPER_RESPONSE = 'result';
    const WRAPPER_META = 'meta';
    const WRAPPER_MESSAGES = 'messages';
    
    /** @var int */
    private $statusCode = 200;

    /**
     * @param int $code
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
    }

    /**
     * @param array $controllerResult
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function response(array $controllerResult)
    {
        $response = new Response(
            json_encode(
                array(
                    static::WRAPPER_RESPONSE => $controllerResult,
                    static::WRAPPER_META => $this->getMeta(),
                )
            )
        );
        $response->setStatusCode($this->statusCode);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return bool
     */
    protected function isFormValid(FormInterface $form)
    {
        if ($form->isValid()) {
            return true;
        }

        foreach ($form->getErrors(true) as $error) {
            $origin = $error->getOrigin()->getName();
            if (!empty($origin)) {
                MetaService::addMessage($error->getOrigin()->getName() . ': ' . $error->getMessage(), MetaService::TYPE_ERROR);
            } else {
                MetaService::addMessage($error->getMessage(), MetaService::TYPE_ERROR);
            }
        }

        return false;
    }

    /**
     * @return array
     */
    private function getMeta()
    {
        if (!MetaService::hasMessages()) {
            return array();
        }

        if (MetaService::hasMessageOfType(MetaService::TYPE_ERROR)) {
            $this->statusCode = static::STATUS_UNPROCESSABLE;
        }

        return array(static::WRAPPER_MESSAGES => MetaService::getMessages());
    }
}
