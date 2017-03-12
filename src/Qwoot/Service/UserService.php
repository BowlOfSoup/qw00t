<?php

namespace Qwoot\Service;

use Doctrine\DBAL\Connection;

class UserService
{
    const ID = 'qwoot.service.user_service';

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
}
