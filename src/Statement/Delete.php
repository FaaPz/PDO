<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatement;
use PDO;

class Delete extends AdvancedStatement
{
    /** @var string|array<string, string> $table */
    protected $table;

    /**
     * @param PDO                               $dbh
     * @param string|array<string, string>|null $table
     */
    public function __construct(PDO $dbh, $table = null)
    {
        parent::__construct($dbh);

        if (!empty($table)) {
            $this->from($table);
        }
    }

    /**
     * @param string|array<string, string> $table
     *
     * @return $this
     */
    public function from($table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return array<int, mixed>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->join as $join) {
            $values = array_merge($values, $join->getValues());
        }

        if ($this->where != null) {
            $values = array_merge($values, $this->where->getValues());
        }

        if (!empty($this->orderBy)) {
            $values = array_merge($values, $this->orderBy);
        }

        return $values;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (empty($this->table)) {
            trigger_error('No table set for delete statement', E_USER_ERROR);
        }

        $sql = 'DELETE';
        if (is_array($this->table)) {
            reset($this->table);
            $alias = key($this->table);

            $table = $this->table[$alias];
            if (is_string($alias)) {
                $table .= " AS {$alias}";
            }
        } else {
            $table = "{$this->table}";
        }
        $sql .= " FROM {$table}";

        if (!empty($this->join)) {
            $sql .= ' ' . implode(' ', $this->join);
        }

        if ($this->where !== null) {
            $sql .= " WHERE {$this->where}";
        }

        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY ';
            foreach ($this->orderBy as $column => $direction) {
                $sql .= "{$column} {$direction}, ";
            }
            $sql = substr($sql, 0, -2);
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
}
