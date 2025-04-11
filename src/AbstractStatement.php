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
            foreach ($this->getValues() as $i => $value) {
                $type = PDO::PARAM_STR;
                if ($value === null) {
                    $type = PDO::PARAM_NULL;
                } elseif (is_bool($value)) {
                    $type = PDO::PARAM_BOOL;
                } elseif (is_int($value)) {
                    $type = PDO::PARAM_INT;
                }

                $stmt->bindValue($i + 1, $value, $type);
            }

            $stmt->execute();
        }

        return $stmt;
    }
}
