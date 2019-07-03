<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatement;
use FaaPz\PDO\DatabaseException;
use PDO;

class Delete extends AdvancedStatement
{
    /** @var string $table */
    protected $table;

    /**
     * @param PDO    $dbh
     * @param string $table
     */
    public function __construct(PDO $dbh, $table = null)
    {
        parent::__construct($dbh);

        $this->table = $table;
    }

    /**
     * @param $table
     *
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
        if (!isset($this->table)) {
            throw new DatabaseException('No table is set for deletion');
        }

        $sql = "DELETE FROM {$this->table}";
        $sql .= implode(' ', $this->join);

        if ($this->where !== null) {
            $sql .= " WHERE {$this->where}";
        }

        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY '.implode(', ', $this->orderBy);
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
        $values = [];

        if ($this->where !== null) {
            $values = array_merge($values, $this->where->getValues());
        }

        if ($this->limit !== null) {
            $values = array_merge($values, $this->limit->getValues());
        }

        return $values;
    }
}
