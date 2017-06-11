<?php

namespace Qwoot\Controller;

use Generic\Controller\AbstractController;
use Generic\FormType\FormTypeInterface;
use Qwoot\Service\QuoteService;
use Security\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuoteController extends AbstractController
{
    /** @var \Qwoot\Service\QuoteService */
    private $quoteService;

    /** @var \Generic\FormType\FormTypeInterface */
    private $quoteFormType;

    /** @var \Security\Service\UserService */
    private $userService;

    /**
     * @param \Qwoot\Service\QuoteService $quoteService
     * @param \Generic\FormType\FormTypeInterface $quoteFormType
     * @param \Security\Service\UserService $userService
     */
    public function __construct(
        QuoteService $quoteService,
        FormTypeInterface $quoteFormType,
        UserService $userService
    ) {
        $this->quoteService = $quoteService;
        $this->quoteFormType = $quoteFormType;
        $this->userService = $userService;
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
     * @param int $quoteId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($quoteId)
    {
        $existingQuote = $this->quoteService->find($quoteId);
        if (!$existingQuote) {
            $this->statusCode = Response::HTTP_NOT_FOUND;

            return $this->response();
        }

        $authenticatedUser = $this->userService->getAuthenticatedUser();
        if ($authenticatedUser['id'] !== $existingQuote['user_id']) {
            $this->statusCode = Response::HTTP_FORBIDDEN;

            return $this->response();
        }

        $this->quoteService->delete($quoteId);

        $this->statusCode = Response::HTTP_NO_CONTENT;

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
