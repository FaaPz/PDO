<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatement;
use FaaPz\PDO\Clause;
use FaaPz\PDO\QueryInterface;
use PDO;
use PDOStatement;

/**
 * @method PDOStatement execute()
 */
class Select extends AdvancedStatement
{
    /** @var string|array<string, string|Select>|null $table */
    protected $table = null;

    /** @var array<int|string, string> $columns */
    protected $columns = [];

    /** @var bool $distinct */
    protected $distinct = false;

    /** @var array<int, Select> $union */
    protected $union = [];

    /** @var array<int, Select> $unionAll */
    protected $unionAll = [];

    /** @var array<int, string> $groupBy */
    protected $groupBy = [];

    /** @var Clause\Conditional|null $having */
    protected $having = null;

    /**
     * @param PDO      $dbh
     * @param string[] $columns
     */
    public function __construct(PDO $dbh, array $columns = ['*'])
    {
        parent::__construct($dbh);

        $this->columns($columns);
    }

    /**
     * @return $this
     */
    public function distinct(): self
    {
        $this->distinct = true;

        return $this;
    }

    /**
     * @param array<int|string, string> $columns
     *
     * @return $this
     */
    public function columns(array $columns = ['*']): self
    {
        if (empty($columns)) {
            $this->columns = ['*'];
        } else {
            $this->columns = $columns;
        }

        return $this;
    }

    /**
     * @param string|array<string, string|Select> $table
     *
     * @return $this
     */
    public function from($table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param Clause\Join $clause
     *
     * @return $this
     */
    public function join(Clause\Join $clause): self
    {
        $this->join[] = $clause;

        return $this;
    }

    protected function getUnionCount(): int
    {
        return count($this->union) + count($this->unionAll);
    }

    /**
     * @param self $query
     *
     * @return $this
     */
    public function union(self $query): self
    {
        $this->union[$this->getUnionCount()] = $query;

        return $this;
    }

    /**
     * @param self $query
     *
     * @return $this
     */
    public function unionAll(self $query): self
    {
        $this->unionAll[$this->getUnionCount()] = $query;

        return $this;
    }

    /**
     * @param string ...$columns
     *
     * @return $this
     */
    public function groupBy(string ...$columns): self
    {
        $this->groupBy = array_merge($this->groupBy, $columns);

        return $this;
    }

    /**
     * @param Clause\Conditional $clause
     *
     * @return $this
     */
    public function having(Clause\Conditional $clause): self
    {
        $this->having = $clause;

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

        if ($this->having != null) {
            $values = array_merge($values, $this->having->getValues());
        }

        return $values;
    }

    /**
     * @return string
     */
    protected function getColumns(): string
    {
        $columns = '';
        foreach ($this->columns as $key => $value) {
            if (!empty($columns)) {
                $columns .= ', ';
            }

            if ($value instanceof QueryInterface) {
                $column = "({$value})";
            } else {
                $column = $value;
            }

            if (is_string($key)) {
                $column .= " AS {$key}";
            }

            $columns .= $column;
        }

        return $columns;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (empty($this->table)) {
            trigger_error('No table set for select statement', E_USER_ERROR);
        }

        $sql = 'SELECT';
        if ($this->distinct) {
            $sql .= ' DISTINCT';
        }

        $sql .= " {$this->getColumns()}";

        if (is_array($this->table)) {
            $table = reset($this->table);
            if ($table instanceof QueryInterface) {
                $table = "({$table})";
            }

            $alias = key($this->table);
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

        if ($this->where != null) {
            $sql .= " WHERE {$this->where}";
        }

        if (!empty($this->groupBy)) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groupBy);
        }

        if ($this->having != null) {
            $sql .= " HAVING {$this->having}";
        }

        if ($direction = reset($this->orderBy)) {
            $column = key($this->orderBy);
            $sql .= " ORDER BY {$column} {$direction}";

            while ($direction = next($this->orderBy)) {
                $column = key($this->orderBy);
                $sql .= ", {$column} {$direction}";
            }
        }

        for ($i = 0; $i < $this->getUnionCount(); $i++) {
            if (isset($this->union[$i])) {
                $union = "{$this->union[$i]}";
            } else {
                $union = "ALL {$this->unionAll[$i]}";
            }
            $sql .= " UNION {$union}";
        }

        return $sql;
    }
}
