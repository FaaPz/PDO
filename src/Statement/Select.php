<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatement;
use FaaPz\PDO\Clause;
use FaaPz\PDO\DatabaseException;
use FaaPz\PDO\StatementInterface;
use PDO;

class Select extends AdvancedStatement
{
    /** @var string|string[string]|Select[string] $table */
    protected $table;

    /** @var string[]|StatementInterface[] $columns */
    protected $columns = [];

    /** @var bool $distinct */
    protected $distinct = false;

    /** @var Select[]|Call[] */
    private $union = [];

    /** @var string[] $groupBy */
    protected $groupBy = [];

    /** @var Clause\Conditional|null $having */
    protected $having = null;

    /**
     * @param PDO                      $dbh
     * @param string[]|Clause\Method[] $columns
     */
    public function __construct(PDO $dbh, array $columns = ['*'])
    {
        parent::__construct($dbh);

        if (empty($columns)) {
            $columns = ['*'];
        }

        $this->columns = $columns;
    }

    /**
     * @return $this
     */
    public function distinct()
    {
        $this->distinct = true;

        return $this;
    }

    /**
     * @param Select $query
     *
     * @return $this
     */
    public function union(self $query)
    {
        $this->union[] = $query;

        return $this;
    }

    /**
     * @param string|string[string]|Select[string] $table
     *
     * @return $this
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param Clause\Join|Clause\Join[] $clause
     *
     * @return $this
     */
    public function join(Clause\Join $clause)
    {
        if (is_array($clause)) {
            $this->join = array_merge($this->join[], array_values($clause));
        } else {
            $this->join[] = $clause;
        }

        return $this;
    }

    /**
     * @param string|string[] $column
     *
     * @return $this
     */
    public function groupBy($column)
    {
        if (is_array($column)) {
            $this->groupBy = array_merge($this->groupBy[], array_values($column));
        } else {
            $this->groupBy[] = $column;
        }

        return $this;
    }

    /**
     * @param Clause\Conditional $clause
     *
     * @return $this
     */
    public function having(Clause\Conditional $clause)
    {
        $this->having = $clause;

        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        $values = [];

        foreach ($this->join as $join) {
            $values = array_merge($values, $join->getValues());
        }

        if ($this->where !== null) {
            $values = array_merge($values, $this->where->getValues());
        }

        if ($this->having !== null) {
            $values = array_merge($values, $this->having->getValues());
        }

        if ($this->limit !== null) {
            $values = array_merge($values, $this->limit->getValues());
        }

        return $values;
    }

    /**
     * @return string
     */
    protected function getColumns()
    {
        $columns = '';

        foreach ($this->columns as $key => $value) {
            if ($value instanceof StatementInterface) {
                $columns .= "({$value})";
            } else {
                $columns .= "{$value}";
            }

            if (is_string($key)) {
                $columns .= " AS {$key}";
            }
            $columns .= ', ';
        }

        return preg_replace('/, $/', '', $columns);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!isset($this->table)) {
            throw new DatabaseException('No table is set for selection');
        }

        $sql = 'SELECT';
        if ($this->distinct) {
            $sql .= ' DISTINCT';
        }

        $sql .= " {$this->getColumns()}";

        if (is_array($this->table)) {
            $alias = array_key_first($this->table);

            $table = "{$this->table[$alias]}";
            if ($this->table[$alias] instanceof self) {
                $table = "({$table})";
            }

            if (is_string($alias)) {
                $table .= " AS {$alias}";
            }
        } else {
            $table = "{$this->table}";
        }
        $sql .= " FROM {$table}";

        if (count($this->join) > 0) {
            $sql .= ' '.implode(' ', $this->join);
        }

        if ($this->where !== null) {
            $sql .= " WHERE {$this->where}";
        }

        if (!empty($this->groupBy)) {
            $sql .= ' GROUP BY '.implode(', ', $this->groupBy);
        }

        if ($this->having !== null) {
            $sql .= " HAVING {$this->having}";
        }

        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY '.implode(', ', $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
        }

        if (count($this->union) > 0) {
            $sql = '('.$sql.implode(') UNION (', $this->union).')';
        }

        return $sql;
    }
}
