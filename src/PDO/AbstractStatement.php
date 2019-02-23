<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO;

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
     * @return array
     */
    abstract public function getValues();

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @throws PDOException
     *
     * @return PDOStatement
     */
    public function execute()
    {
        $stmt = $this->dbh->prepare($this->__toString());

        try {
            $success = $stmt->execute($this->getValues());
            if (!$success) {
                $info = $stmt->errorInfo();

                throw new Exception($info[2], $info[0]);
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        return $stmt;
    }
}
