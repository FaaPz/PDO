<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\AbstractStatement;
use Slim\PDO\Clause;
use Slim\PDO\Database;

/**
 * Class Select.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 * @author Alex Barker <alex@1stleg.com>
 */
class Select extends AbstractStatement
{
    /**
     * @var bool $distinct
     */
    protected $distinct = false;

    /**
     * @var Clause\Join[]
     */
    protected $join = array();

    /**
     * @var string[] $groupBy
     */
    protected $groupBy = array();

    /**
     * @var Clause\Conditional|null $having
     */
    protected $having;

    /**
     * Constructor.
     *
     * @param Database $dbh
     * @param string[]|Clause\Expression[] $columns
     */
    public function __construct(Database $dbh, array $columns = ["*"])
    {
        parent::__construct($dbh);

        if (empty($columns)) {
            $columns = array("*");
        }

        $this->setColumns($columns);
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
     * @param $table
     *
     * @return $this
     */
    public function from($table)
    {
        $this->setTable($table);

        return $this;
    }

    /**
     * @param Clause\Join|Clause\Join[] $clause
     *
     * @return $this
     */
    public function join(Clause\Join $clause) {
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
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            trigger_error('No table is set for selection', E_USER_ERROR);
        }

        $sql = "SELECT";

        if ($this->distinct) {
            $sql .= " DISTINCT";
        }

        $sql .= " {$this->getColumns()} FROM {$this->table} ";

        if (count($this->join) > 0) {
            $sql .= implode(" ", $this->join);
        }

        if (isset($this->where)) {
            $sql .= " WHERE {$this->where}";
        }

        if (count($this->groupBy) > 0) {
            $sql .= " GROUP BY " . implode(", ", $this->groupBy);
        }

        if (isset($this->having)) {
            $sql .= " HAVING {$this->having}";
        }

        if (count($this->orderBy) > 0) {
            $sql .= " ORDER BY " . implode(", ", $this->orderBy);
        }

        if ($this->limit != null) {
            $sql .= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    public function getValues()
    {
        // Only clauses have values.
        $values = parent::getValues();

        foreach ($this->join as $join) {
            $values += $join->getValues();
        }

        $values += $this->where->getValues()
                + $this->having->getValues()
                + $this->limit->getValues();

        return $values;
    }

    protected function getColumns() {
        $columns = "";

        foreach ($this->columns as $key => $value) {
            if (is_string($key)) {
                $columns .= "{$key} AS {$value}, ";
            } else {
                $columns .= "{$value}, ";
            }
        }

        return rtrim($columns, ", ");
    }
}
