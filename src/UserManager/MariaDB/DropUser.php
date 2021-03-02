<?php

namespace FaaPz\PDO\UserManager\MariaDB;

use PDO;
use FaaPz\PDO\AbstractStatement;

class DropUser extends AbstractStatement
{

    /**
     * User information
     */
    protected string $user;
    protected string $host;

    /**
     * Clauses
     */
    protected bool $ifExists = false; 

    public function __construct(PDO $pdo, string $host, string $user)
    {
        parent::__construct($pdo);
        $this->user = $user;
        $this->host = $host;
    }

    public function ifExists()
    {
        $this->ifExists = true;
        return $this;
    }

    public function getValues(): array
    {
        return [];
    }

    public function __toString(): string
    {
        $sql = 'DROP USER';

        if ($this->ifExists) {
            $sql = "{$sql} IF EXISTS {$this->user}@{$this->host}";
        } else {
            $sql = "{$sql} {$this->user}@{$this->host}";
        }

        return $sql;
    }
}

