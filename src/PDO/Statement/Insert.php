<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\AbstractStatement;
use Slim\PDO\Database;

class Insert extends AbstractStatement
{
    /** @var string[] $columns */
    protected $columns = array();

    /** @var array $values */
    protected $values = array();

    /**
     * @param Database $dbh
     * @param array $pairs
     */
    public function __construct(Database $dbh, array $pairs = [])
    {
        parent::__construct($dbh);

        $this->columns(array_keys($pairs));
        $this->values(array_values($pairs));
    }

    /**
     * @param $table
     * @return $this
     */
    public function into($table)
    {
        $this->setTable($table);

        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->columns += $columns;

        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function values(array $values)
    {
        $this->values += $values;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (! isset($this->table)) {
            trigger_error("No table is set for insertion", E_USER_ERROR);
        }

        if (empty($this->columns)) {
            trigger_error("Missing columns for insertion", E_USER_ERROR);
        }

        if (empty($this->values)) {
            trigger_error("Missing values for insertion", E_USER_ERROR);
        }

        $columns = implode(", ", $this->columns);
        $placeholders = rtrim(str_repeat("?, ", count($this->values)), ", ");

        $sql = "INSERT INTO {$this->table} ({$columns})";
        $sql .= " VALUES ({$placeholders})";

        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        parent::execute();

        return (int) $this->dbh->lastInsertId();
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
}
