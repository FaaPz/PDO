<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\AbstractStatement;
use Slim\PDO\Database;

class Delete extends AbstractStatement
{
    /**
     * @param Database $dbh
     * @param $table
     */
    public function __construct(Database $dbh, $table = null)
    {
        parent::__construct($dbh);

        $this->setTable($table);
    }

    /**
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (! isset($this->table)) {
            trigger_error("No table is set for deletion", E_USER_ERROR);
        }

        $sql = "DELETE FROM {$this->table}";
        if ($this->where !== null) {
            $sql .= " WHERE {$this->where}";
        }

        if (! empty($this->orderBy)) {
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
     * @return array
     */
    public function getValues()
    {
        $values = array();

        if ($this->where !== null) {
            $values += $this->where->getValues();
        }

        if ($this->limit !== null) {
            $values += $this->limit->getValues();
        }

        return $values;
    }
}
