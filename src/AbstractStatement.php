<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use PDO;
use PDOException;
use PDOStatement;

abstract class AbstractStatement implements StatementInterface
{
    /** @var PDO $dbh */
    protected $dbh;


    /**
     * @param PDO $dbh
     */
    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @return PDOStatement|false
     * @throws PDOException
     */
    public function execute()
    {
        $stmt = $this->dbh->prepare($this->__toString());
        if ($stmt !== false) {
            $stmt->execute($this->getValues());
        }

        return $stmt;
    }
}
