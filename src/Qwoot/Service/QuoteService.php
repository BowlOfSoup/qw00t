<?php

namespace Qwoot\Service;

use Doctrine\DBAL\Connection;

class QuoteService
{
    const ID = 'qwoot.service.quote_service';

    /** @var \Doctrine\DBAL\Connection */
    private $db;

    /**
     * @param \Doctrine\DBAL\Connection $databaseConnection
     */
    public function __construct(
        Connection $databaseConnection
    ) {
        $this->db = $databaseConnection;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM quote');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param int $numberOfEntries
     *
     * @return array
     */
    public function findRandom($numberOfEntries = 5)
    {
        $stmt = $this->db->prepare('SELECT * FROM quote WHERE id IN (SELECT id FROM quote ORDER BY RANDOM() LIMIT :limit)');
        $stmt->bindValue('limit', $numberOfEntries);
        $stmt->execute();

        return $this->prepare($stmt->fetchAll());
    }

    /**
     * @param array $quotes
     *
     * @return array
     */
    private function prepare(array $quotes)
    {
        foreach ($quotes as $key => $quote) {
            $quotes[$key]['context'] = ucfirst($quote['context']);
            $quotes[$key]['quote'] = ucfirst($quote['quote']);
            $quotes[$key]['person'] = $this->handleNames($quote['person']);
        }

        return $quotes;
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function handleNames($name)
    {
        $prefixLowercase = array('van', 'der', 'de');
        $preparedName = null;

        $i = 1;
        $parts = explode(' ', strtolower($name));
        foreach($parts as $part) {
            if ($i > 1) {
                $preparedName .= ' ';
            }
            (!in_array($part, $prefixLowercase)) ? $preparedName .= ucwords($part) : $preparedName .= $part;
            ++$i;
        }

        return $preparedName;
    }
}
