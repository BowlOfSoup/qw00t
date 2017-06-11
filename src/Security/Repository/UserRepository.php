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
     * Find one record by id.
     *
     * @param int $id
     *
     * @return array
     */
    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->bindValue('id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Find record by user name.
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

    /**
     * Find record by user email.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function findByEmail($value)
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE email = :value');
        $stmt->bindValue('value', $value);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function insert(array $data)
    {
        $result = $this->db->insert(static::TABLE, $data);
        if (0 !== $result) {
            return $this->db->lastInsertId();
        }

        return 0;
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function update(array $data, $id)
    {
        return $this->db->update(static::TABLE, $data, array('id' => $id));
    }
}
