<?php

namespace Qwoot\Service;

use Doctrine\DBAL\DBALException;
use Generic\Service\MetaService;
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
     * @param array $data
     *
     * @return int
     */
    public function update(array $data)
    {
        return $this->quoteRepository->update($data, $data['id']);
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
