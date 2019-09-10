<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use PDO;
use PDOException;
use PDOStatement;

abstract class AbstractStatement implements QueryInterface
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
     * @throws DatabaseException
     *
     * @return int|string|PDOStatement
     */
    public function execute()
    {
        $stmt = $this->dbh->prepare($this->__toString());

        try {
            $success = $stmt->execute($this->getValues());
            if (!$success) {
                $info = $stmt->errorInfo();

                throw new DatabaseException($info[2], $info[0]);
            }
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }

        return $stmt;
    }
}
