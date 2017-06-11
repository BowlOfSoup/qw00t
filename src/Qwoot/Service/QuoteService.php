<?php

namespace Qwoot\Service;

use Generic\Service\PersonService;
use Qwoot\Repository\QuoteRepository;

class QuoteService
{
    /** @var \Doctrine\DBAL\Connection */
    private $quoteRepository;

    /**
     * @param \Qwoot\Repository\QuoteRepository $quoteRepository
     */
    public function __construct(
        QuoteRepository $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function find($id)
    {
        return $this->quoteRepository->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->quoteRepository->findAll();
    }

    /**
     * @param int $numberOfEntries
     *
     * @return array
     */
    public function findRandom($numberOfEntries = 5)
    {
        return $this->prepare($this->quoteRepository->findRandom($numberOfEntries));
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function insert(array $data)
    {
        return $this->quoteRepository->insert($data);
    }

    /**
     * @param int $quoteId
     *
     * @return int
     */
    public function delete($quoteId)
    {
        return $this->quoteRepository->delete($quoteId);
    }

    /**
     * Prepare quotes for Response.
     *
     * @param array $quotes
     *
     * @return array
     */
    private function prepare(array $quotes)
    {
        foreach ($quotes as $key => $quote) {
            $quotes[$key]['context'] = ucfirst($quote['context']);
            $quotes[$key]['quote'] = ucfirst($quote['quote']);
            $quotes[$key]['person'] = PersonService::transformName($quote['person']);
        }

        return $quotes;
    }
}
