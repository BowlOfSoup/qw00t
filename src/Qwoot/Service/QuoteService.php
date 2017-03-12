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
    public function findRandom($numberOfEntries = 20)
    {
        $stmt = $this->db->prepare('SELECT * FROM quote WHERE id IN (SELECT id FROM quote ORDER BY RANDOM() LIMIT :limit)');
        $stmt->bindValue('limit', $numberOfEntries);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
