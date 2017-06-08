<?php

namespace Security\Repository;

use Doctrine\DBAL\Connection;

class UserRepository
{
    const TABLE = 'user';

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
     * Find record by criteria.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function findByUsername($value)
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE username = :value');
        $stmt->bindValue('value', $value);
        $stmt->execute();

        return $stmt->fetch();
    }
}
