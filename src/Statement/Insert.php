<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AbstractStatement;
use FaaPz\PDO\DatabaseException;
use FaaPz\PDO\QueryInterface;
use PDO;

class Insert extends AbstractStatement
{
    /** @var string $table */
    protected $table;

    /** @var string[] $columns */
    protected $columns = [];

    /** @var mixed[] $values */
    protected $values = [];

    /** @var bool $ignore */
    protected $ignore = false;

    /**
     * @param PDO                  $dbh
     * @param array<string, mixed> $pairs
     */
    public function __construct(PDO $dbh, array $pairs = [])
    {
        parent::__construct($dbh);

        $this->pairs($pairs);
    }

    /**
     * @param string $table
     *
     * @return $this
     */
    public function into(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param string ...$columns
     *
     * @return $this
     */
    public function columns(string ...$columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param mixed ...$values
     *
     * @return $this
     */
    public function values(...$values): self
    {
        $this->values = $values;

        return $this;
    }

    /**
     * @param array<string, mixed> $pairs
     *
     * @return $this
     */
    public function pairs(array $pairs): self
    {
        $this->columns(...array_keys($pairs));
        $this->values(...array_values($pairs));

        return $this;
    }

    /**
     * @return $this
     */
    public function ignore(): self
    {
        $this->ignore = true;

        return $this;
    }

    /**
     * @throws DatabaseException
     *
     * @return string
     */
    public function __toString(): string
    {
        if (empty($this->table)) {
            throw new DatabaseException('No table is set for insertion');
        }

        if (empty($this->columns)) {
            throw new DatabaseException('Missing columns for insertion');
        }

        if (empty($this->values) || count($this->columns) != count($this->values)) {
            throw new DatabaseException('Missing values for insertion');
        }

        $placeholders = '';
        foreach ($this->values as $value) {
            if (!empty($placeholders)) {
                $placeholders .= ', ';
            }

            if ($value instanceof QueryInterface) {
                $placeholders .= "{$value}";
            } else {
                $placeholders .= '?';
            }
        }

        $columns = implode(', ', $this->columns);

        $sql = 'INSERT';
        if ($this->ignore) {
            $sql .= ' IGNORE';
        }
        $sql .= " INTO {$this->table} ({$columns})";
        $sql .= " VALUES ({$placeholders})";

        return $sql;
    }

    /**
     * @return array<int, mixed>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->values as $value) {
            if ($value instanceof QueryInterface) {
                $values = array_merge($values, $value->getValues());
            } else {
                $values[] = $value;
            }
        }

        return $values;
    }

    /**
     * @throws DatabaseException
     *
     * @return int|string
     */
    public function execute()
    {
        parent::execute();

        return $this->dbh->lastInsertId();
    }
}
