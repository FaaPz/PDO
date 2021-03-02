<?php

namespace FaaPz\PDO\UserManager\MariaDB;

use PDO;
use FaaPz\PDO\AbstractStatement;

class RevokePrivileges extends AbstractStatement
{
    /**
     * User information
     */
    protected string $host;
    protected string $user;
    protected string $database;
    protected string $table;

    /**
     * ALL PRIVILEGES, CREATE, DROP, DELETE, INSERT, SELECT, UPDATE, GRANT OPTION  
     */
    protected array $privilegesArray = [];

    public function __construct(PDO $pdo, string $host, string $user, ?string $database = '', ?string $table = '')
    {
        parent::__construct($pdo);
        $this->host = $host;
        $this->user = $user;
        $this->database = $database;
        $this->table = $table;
    }

    /**
     * All privileges to user
     */
    public function allPrivileges()
    {
        $this->allPrivileges = true;
        return $this;
    }

    public function privileges(?array $privileges = ['ALL PRIVILEGES'])
    {
        $this->privilegesArray = $privileges;

        return $this;
    }

    public function getValues(): array
    {
        return [];
    }

    public function __toString(): string
    {      

        
        if (count($this->privilegesArray) == 0) {
            throw new \Exception('Privileges is null');
        }
        

        $sql = "REVOKE";        
     
        if ($this->privilegesArray[0] != 'ALL PRIVILEGES') {
        
            $limit = \count($this->privilegesArray);  
            $i = 1;
            foreach($this->privilegesArray as $privileges) {
                if ($i < $limit)
                    $sql = "{$sql} {$privileges},";
                else 
                    $sql = "{$sql} {$privileges}";
                $i++;
            }
        } else {
            $sql = "{$sql} ALL PRIVILEGES";
        }

        /**
         * Select database or table name
         */
        if ($this->database != '') {
            $sql = "{$sql} ON {$this->database}";
        } else {
            $sql = "{$sql} ON *";
        }

        if ($this->table != '') {
            $sql = "{$sql}.{$this->table}";
        } else {
            $sql = "{$sql}.*";
        }

        $sql = "{$sql} FROM {$this->user}@{$this->host}";

        return $sql;
    }
}



   
    