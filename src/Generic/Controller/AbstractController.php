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

    /** @var array */
    protected $responseMapping = array();

    /** @var int */
    protected $statusCode = 200;

    /**
     * @param array $controllerResult
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function response(array $controllerResult = array())
    {
        if (!empty($controllerResult) && !array_key_exists(0, $controllerResult)) {
            // Controller result must be sequential array.
            $controllerResult = array($controllerResult);
        }

        $controllerResult = $this->prepareProperties($controllerResult);

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

    /**
     * @param array $controllerResult
     *
     * @return array
     */
    private function prepareProperties(array $controllerResult)
    {
        foreach ($controllerResult as $key => $item) {
            $controllerResult = $this->mapPropertiesForResponse($controllerResult, $key);

            ksort($controllerResult[$key]);
        }

        return $controllerResult;
    }

    /**
     * @param array $controllerResult
     * @param string|int $parentKey
     *
     * @return array
     */
    private function mapPropertiesForResponse(array $controllerResult, $parentKey)
    {
        if (empty($this->responseMapping)) {
            return $controllerResult;
        }

        foreach ($this->responseMapping as $originalKey => $replacementKey) {
            $controllerResult[$parentKey][$replacementKey] = $controllerResult[$parentKey][$originalKey];
            unset($controllerResult[$parentKey][$originalKey]);
        }
        return $controllerResult;
    }
}
