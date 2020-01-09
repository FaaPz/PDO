<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatement;
use FaaPz\PDO\QueryInterface;
use PDO;

class Update extends AdvancedStatement
{
    /** @var string $table */
    protected $table;

    /** @var array<string, mixed> $pairs */
    protected $pairs;

    /**
     * @param PDO                  $dbh
     * @param array<string, mixed> $pairs
     */
    public function __construct(PDO $dbh, array $pairs = [])
    {
        parent::__construct($dbh);

        $this->pairs = $pairs;
    }

    /**
     * @param string $table
     *
     * @return $this
     */
    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array<string, mixed> $pairs
     *
     * @return $this
     */
    public function pairs(array $pairs): self
    {
        $this->pairs = array_merge($this->pairs, $pairs);

        return $this;
    }

    /**
     * @param string $column
     * @param mixed  $value
     *
     * @return $this
     */
    public function set(string $column, $value): self
    {
        $this->pairs[$column] = $value;

        return $this;
    }

    /**
     * @return array<int, mixed>
     */
    public function getValues(): array
    {
        $values = array_values($this->pairs);

        if ($this->where !== null) {
            $values = array_merge($values, $this->where->getValues());
        }

        if ($this->limit !== null) {
            $values = array_merge($values, $this->limit->getValues());
        }

        return $values;
    }

    /**
     * @return string
     */
    protected function getColumns(): string
    {
        $columns = '';
        foreach ($this->pairs as $key => $value) {
            if (!empty($columns)) {
                $columns .= ', ';
            }

            if ($value instanceof QueryInterface) {
                $columns .= "{$key} = ({$value})";
            } else {
                $columns .= "{$key} = ?";
            }
        }

        return $columns;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!isset($this->table)) {
            trigger_error('No table set for update statement', E_USER_ERROR);
        }

        if (empty($this->pairs)) {
            trigger_error('No column / value pairs set for update statement', E_USER_ERROR);
        }

        $sql = "UPDATE {$this->table}";
        if (!empty($this->join)) {
            $sql .= ' ' . implode(' ', $this->join);
        }

        $sql .= " SET {$this->getColumns()}";
        if ($this->where != null) {
            $sql .= " WHERE {$this->where}";
        }

        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY ';
            foreach ($this->orderBy as $column => $direction) {
                $sql .= "{$column} {$direction}, ";
            }
            $sql = substr($sql, 0, -2);
        }

        if ($this->limit != null) {
            $sql .= " {$this->limit}";
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
