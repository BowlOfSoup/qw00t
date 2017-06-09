<?php

namespace Qwoot\Controller;

use Generic\Controller\AbstractController;
use Generic\FormType\FormTypeInterface;
use Qwoot\Service\QuoteService;
use Symfony\Component\HttpFoundation\Request;

class QuoteController extends AbstractController
{
    /** @var \Qwoot\Service\QuoteService */
    private $quoteService;

    /** @var \Generic\FormType\FormTypeInterface */
    private $quoteFormType;

    /**
     * @param \Qwoot\Service\QuoteService $quoteService
     * @param \Generic\FormType\FormTypeInterface $quoteFormType
     */
    public function __construct(
        QuoteService $quoteService,
        FormTypeInterface $quoteFormType
    ) {
        $this->quoteService = $quoteService;
        $this->quoteFormType = $quoteFormType;
    }

    /**
     * Get of filter list of quotes.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getListAction(Request $request)
    {
        if ($request->get('random')) {
            return $this->response($this->quoteService->findRandom());
        }

        return $this->response($this->quoteService->findAll());
    }

    /**
     * Create a quote.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $quoteForm = $this->quoteFormType->buildForm();
        $quoteForm->handleRequest($request);

        if ($this->isFormValid($quoteForm)) {
            $result = $this->quoteService->insert($quoteForm->getData());
            if (0 === $result) {
                return $this->response();
            }

            return $this->response($quoteForm->getData());
        }

        return $this->response();
    }

    /**
     * {@inheritdoc}
     */
    protected function response(array $controllerResult = array())
    {
        $this->responseMapping = array('user_id' => 'user');

        return parent::response($controllerResult);
    }
}
