<?php

namespace Pb\PDO;

class Statement extends \PDOStatement
{
    /**
     * @var Database
     */
    protected $dbh;

    protected function __construct(Database $dbh)
    {
        $this->dbh = $dbh;
    }
}
