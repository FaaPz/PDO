<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Statement;

use PDO;
use Slim\PDO\AbstractStatement;
use Slim\PDO\Clause;

class Update extends AbstractStatement
{
    /** @var array $pairs */
    protected $pairs;

    /** @var Clause\Join[] $join */
    protected $join = [];

    /**
     * @param PDO   $dbh
     * @param array $pairs
     */
    public function __construct(PDO $dbh, array $pairs = [])
    {
        parent::__construct($dbh);

        $this->pairs = $pairs;
    }

    /**
     * @param  $table
     *
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $pairs
     *
     * @return $this
     */
    public function set(array $pairs)
    {
        $this->pairs = $pairs;

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
     * @return string
     */
    public function __toString()
    {
        if (!isset($this->table)) {
            trigger_error('No table is set for update', E_USER_ERROR);
        }

        if (empty($this->pairs)) {
            trigger_error('Missing columns and values for update', E_USER_ERROR);
        }

        $sql = "UPDATE {$this->table}";
        $sql .= implode(' ', $this->join);

        $columns = array_keys($this->pairs);
        $column = sarray_pop($columns);
        $column = str_replace('.', '`.`', $column);
        $sql .= " SET `{$column}` = ?";

        while (($column = array_pop($columns)) !== null) {
            $column = str_replace('.', '`.`', $column);
            $sql .= ", `{$column}` = ?";
        }

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
        $values = array_values($this->pairs);

        if ($this->where !== null) {
            $values = array_merge($values, $this->where->getValues());
        }

        if ($this->limit !== null) {
            $values = array_merge($values, $this->limit->getValues());
        }

        return $values;
    }
}
