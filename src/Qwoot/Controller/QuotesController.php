<?php

namespace Qwoot\Controller;

use Qwoot\Service\QuoteService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuotesController
{
    const ID = 'qwoot.controller.quotes';

    /** @var \Qwoot\Service\QuoteService */
    private $quoteService;

    public function __construct(
        QuoteService $quoteService
    ) {
        $this->quoteService = $quoteService;
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
}
