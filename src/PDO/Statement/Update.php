<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\AbstractStatement;
use Slim\PDO\Database;

class Update extends AbstractStatement
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

        $this->set($pairs);
    }

    /**
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $pairs
     * @return $this
     */
    public function set(array $pairs)
    {
        foreach ($pairs as $column => $value) {
            $this->columns[] = $column;
            $this->values[] = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (! isset($this->table)) {
            trigger_error("No table is set for update", E_USER_ERROR);
        }

        if (empty($this->columns) || empty($this->values)) {
            trigger_error("Missing columns and values for update", E_USER_ERROR);
        }

        $sql = "UPDATE {$this->table}";
        $sql .= " SET {$this->getColumns()}";

        if ($this->where !== null) {
            $sql .= " WHERE {$this->where}";
        }

        if ($this->orderBy !== null) {
            $sql .= " ORDER BY " . implode(", ", $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        return parent::execute()->rowCount();
    }

    /**
     * @return string
     */
    protected function getColumns()
    {
        return implode(" = ?, ", $this->columns);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        $values = $this->values;

        if ($this->where !== null) {
            $values += $this->where->getValues();
        }

        if ($this->limit !== null) {
            $values += $this->limit->getValues();
        }

        return $values;
    }
}
