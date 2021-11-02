<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatement;
use FaaPz\PDO\Clause\RawInterface;
use FaaPz\PDO\Database;
use FaaPz\PDO\QueryInterface;

class Update extends AdvancedStatement implements UpdateInterface
{
    /** @var string $table */
    protected $table;

    /** @var array<string, float|int|string|RawInterface|SelectInterface> $pairs */
    protected $pairs = [];


    /**
     * @param Database                                                     $dbh
     * @param array<string, float|int|string|RawInterface|SelectInterface> $pairs
     */
    public function __construct(Database $dbh, array $pairs = [])
    {
        parent::__construct($dbh);

        $this->pairs($pairs);
    }

    /**
     * @param string $table
     *
     * @return self
     */
    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderTable(): string
    {
        if (empty($this->table)) {
            trigger_error('No table set for update statement', E_USER_ERROR);
        }

        return " {$this->table}";
    }

    /**
     * @param string                                        $column
     * @param float|int|string|RawInterface|SelectInterface $value
     *
     * @return self
     */
    public function set(string $column, $value): self
    {
        $this->pairs[$column] = $value;

        return $this;
    }

    /**
     * @param array<string, float|int|string|RawInterface|SelectInterface> $pairs
     *
     * @return self
     */
    public function pairs(array $pairs): self
    {
        $this->pairs = array_merge($this->pairs, $pairs);

        return $this;
    }

    /**
     * @return string
     */
    protected function renderPairs(): string
    {
        if (empty($this->pairs)) {
            trigger_error('No column / value pairs set for update statement', E_USER_ERROR);
        }

        $sql = '';
        foreach ($this->pairs as $key => $value) {
            if (!empty($sql)) {
                $sql .= ', ';
            }

            if ($value instanceof SelectInterface) {
                $sql .= "{$key} = ({$value})";
            } elseif ($value instanceof RawInterface) {
                $sql .= "{$key} = {$value}";
            } else {
                $sql .= "{$key} = ?";
            }
        }

        return " SET {$sql}";
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

        foreach ($this->pairs as $value) {
            if ($value instanceof QueryInterface) {
                $values = array_merge($values, $value->getValues());
            } else {
                $values[] = $value;
            }
        }

        if ($this->where != null) {
            $values = array_merge($values, $this->where->getValues());
        }

        if ($this->limit != null) {
            $values = array_merge($values, $this->limit->getValues());
        }

        return $values;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'UPDATE'
            . $this->renderTable()
            . $this->renderJoin()
            . $this->renderPairs()
            . $this->renderWhere()
            . $this->renderOrderBy()
            . $this->renderLimit();
    }
}
