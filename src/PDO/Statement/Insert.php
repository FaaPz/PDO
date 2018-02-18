<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Statement;

use PDO;
use PDOException;
use Slim\PDO\Exception;
use Slim\PDO\StatementInterface;

class Insert implements StatementInterface
{
    /** @var PDO $dbh */
    protected $dbh;

    /** @var string $table */
    protected $table;

    /** @var string[] $columns */
    protected $columns = [];

    /** @var array $values */
    protected $values = [];

    /**
     * @param PDO   $dbh
     * @param array $pairs
     */
    public function __construct(PDO $dbh, array $pairs = [])
    {
        $this->dbh = $dbh;

        $this->columns(array_keys($pairs));
        $this->values(array_values($pairs));
    }

    /**
     * @param $table
     *
     * @return $this
     */
    public function into($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->columns = array_merge($this->columns, $columns);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function values(array $values)
    {
        $this->values = array_merge($this->values, $values);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!isset($this->table)) {
            trigger_error('No table is set for insertion', E_USER_ERROR);
        }

        if (empty($this->columns)) {
            trigger_error('Missing columns for insertion', E_USER_ERROR);
        }

        if (empty($this->values)) {
            trigger_error('Missing values for insertion', E_USER_ERROR);
        }

        $columns = implode(', ', $this->columns);
        $placeholders = rtrim(str_repeat('?, ', count($this->values)), ', ');

        $sql = "INSERT INTO {$this->table} ({$columns})";
        $sql .= " VALUES ({$placeholders})";

        return $sql;
    }

    /**
     * @throws Exception
     *
     * @return string|int
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

        return $this->dbh->lastInsertId();
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
}
