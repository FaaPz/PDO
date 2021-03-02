<?php

namespace FaaPz\PDO\UserManager\MariaDB;

use FaaPz\PDO\AbstractStatement;
use PDO;

class CreateUser extends AbstractStatement
{
    /**
     * User informations
     */
    protected string $user;
    protected string $host;
    protected string $password;
    
    /**
     * Clauses
     */
    protected bool $orReplace = false;
    protected bool $ifNotExists = false;   

    /**
     * 
     */
    public function __construct(PDO $dbh, string $host, string $user, ?string $password = '')
    {
        parent::__construct($dbh);
        $this->host = $host;
        $this->user = $user;        
        $this->password = $password;
    }

    public function getValues(): array
    {
        return [];
    }

    /**
     * 
     */
    public function orReplace()
    {
        $this->orReplace = true;
        return $this;
    }

    /**
     * 
     */
    public function ifNotExists()
    {
        $this->ifNotExists = true;
        return $this;
    }

    public function __toString(): string
    {

        /**
         * Exception: CREATE 'OR REPLACE' USER 'IF NOT EXISTS' ...
         */
        if ($this->orReplace && $this->ifNotExists)
        {
            throw new \Exception('The clause "OR REPLACE" and "IF NOT EXISTS" cannot be used together');
        }


        $sql = 'CREATE';


        if ($this->orReplace) {
            $sql = "{$sql} OR REPLACE USER {$this->user}@{$this->host}";
        }

        if ($this->ifNotExists) {
            $sql = "{$sql} USER IF NOT EXISTS {$this->user}@{$this->host}";
        } 

        if (!$this->ifNotExists && !$this->orReplace) {
            $sql = "{$sql} USER {$this->user}@{$this->host}";
        }

        if ($this->password) {
            $sql = "{$sql} IDENTIFIED BY '{$this->password}'";
        }

        return $sql;
    }
}