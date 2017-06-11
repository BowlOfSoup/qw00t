<?php

namespace Qwoot\Repository;

use Doctrine\DBAL\Connection;

class QuoteRepository
{
    const TABLE = 'quote';

    /** @var \Doctrine\DBAL\Connection */
    private $db;

    /**
     * @param \Doctrine\DBAL\Connection $databaseConnection
     */
    public function __construct(Connection $databaseConnection)
    {
        $this->db = $databaseConnection;
    }

    /**
     * Find one record by id.
     *
     * @param int $id
     *
     * @return array
     */
    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM quote WHERE id = :id');
        $stmt->bindValue('id', $id);
        $stmt->execute();

        return $stmt->fetch();
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

        return $stmt->fetchAll();
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function insert(array $data)
    {
        return $this->db->insert(static::TABLE, $data);
    }

    /**
     * @param int $quoteId
     *
     * @return int
     */
    public function delete($quoteId)
    {
        return $this->db->delete(static::TABLE, array('id' => $quoteId));
    }
}
