<?php

namespace Pb\PDO\Statement;

use Pb\PDO\Clause\GroupClause;
use Pb\PDO\Clause\HavingClause;
use Pb\PDO\Clause\JoinClause;
use Pb\PDO\Clause\OffsetClause;
use Pb\PDO\Database;

class SelectStatement extends StatementContainer
{
    /**
     * @var bool
     */
    protected $distinct = false;

    /**
     * @var bool
     */
    protected $aggregate = false;

    /**
     * @var JoinClause
     */
    protected $joinClause;

    /**
     * @var GroupClause
     */
    protected $groupClause;

    /**
     * @var HavingClause
     */
    protected $havingClause;

    /**
     * @var OffsetClause
     */
    protected $offsetClause;

    public function __construct(Database $dbh, array $columns)
    {
        parent::__construct($dbh);

        if (empty($columns)) {
            $columns = ['*'];
        }

        $this->setColumns($columns);

        $this->joinClause = new JoinClause();
        $this->groupClause = new GroupClause();
        $this->havingClause = new HavingClause();
        $this->offsetClause = new OffsetClause();
    }

    /**
     * @return self
     */
    public function clear()
    {
        $this->columns = [];

        return $this;
    }

    /**
     * @return self
     */
    public function distinct()
    {
        $this->distinct = true;

        return $this;
    }

    /**
     * @param string      $column
     * @param string|null $as
     * @param bool        $distinct
     *
     * @return self
     */
    public function count($column = '*', $as = null, $distinct = false)
    {
        $this->aggregate = true;

        $this->columns[] = $this->setDistinct($distinct).' '.$column.' )'.$this->setAs($as);

        return $this;
    }

    /**
     * @param string      $column
     * @param string|null $as
     *
     * @return self
     */
    public function distinctCount($column = '*', $as = null)
    {
        $this->count($column, $as, true);

        return $this;
    }

    /**
     * @param string      $column
     * @param string|null $as
     *
     * @return self
     */
    public function max($column, $as = null)
    {
        $this->aggregate = true;

        $this->columns[] = 'MAX( '.$column.' )'.$this->setAs($as);

        return $this;
    }

    /**
     * @param string      $column
     * @param string|null $as
     *
     * @return self
     */
    public function min($column, $as = null)
    {
        $this->aggregate = true;

        $this->columns[] = 'MIN( '.$column.' )'.$this->setAs($as);

        return $this;
    }

    /**
     * @param string      $column
     * @param string|null $as
     *
     * @return self
     */
    public function avg($column, $as = null)
    {
        $this->aggregate = true;

        $this->columns[] = 'AVG( '.$column.' )'.$this->setAs($as);

        return $this;
    }

    /**
     * @param string      $column
     * @param string|null $as
     *
     * @return self
     */
    public function sum($column, $as = null)
    {
        $this->aggregate = true;

        $this->columns[] = 'SUM( '.$column.' )'.$this->setAs($as);

        return $this;
    }

    /**
     * @param string $table
     *
     * @return self
     */
    public function from($table)
    {
        $this->setTable($table);

        return $this;
    }

    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     * @param string $joinType
     *
     * @return self
     */
    public function join($table, $first, $operator = null, $second = null, $joinType = 'INNER')
    {
        $this->joinClause->join($table, $first, $operator, $second, $joinType);

        return $this;
    }

    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     *
     * @return self
     */
    public function leftJoin($table, $first, $operator = null, $second = null)
    {
        $this->joinClause->leftJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     *
     * @return self
     */
    public function rightJoin($table, $first, $operator = null, $second = null)
    {
        $this->joinClause->rightJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     *
     * @return self
     */
    public function fullJoin($table, $first, $operator = null, $second = null)
    {
        $this->joinClause->fullJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * @param string $columns
     *
     * @return self
     */
    public function groupBy($columns)
    {
        $this->groupClause->groupBy($columns);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     * @param string $chainType
     *
     * @return self
     */
    public function having($column, $operator = null, $value = null, $chainType = 'AND')
    {
        $this->values[] = $value;

        $this->havingClause->having($column, $operator, $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     *
     * @return self
     */
    public function orHaving($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->havingClause->orHaving($column, $operator);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     *
     * @return self
     */
    public function havingCount($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->havingClause->havingCount($column, $operator);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     *
     * @return self
     */
    public function havingMax($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->havingClause->havingMax($column, $operator);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     *
     * @return self
     */
    public function havingMin($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->havingClause->havingMin($column, $operator);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     *
     * @return self
     */
    public function havingAvg($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->havingClause->havingAvg($column, $operator);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     *
     * @return self
     */
    public function havingSum($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->havingClause->havingSum($column, $operator);

        return $this;
    }

    /**
     * @param int $number
     *
     * @return self
     */
    public function offset($number)
    {
        $this->offsetClause->offset($number);

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

        $sql = $this->getSelect().' '.$this->getColumns();
        $sql .= ' FROM '.$this->table;
        $sql .= $this->joinClause;
        $sql .= $this->whereClause;
        $sql .= $this->groupClause;
        $sql .= $this->havingClause;
        $sql .= $this->orderClause;
        $sql .= $this->limitClause;
        $sql .= $this->offsetClause;

        return $sql;
    }

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        return $this->executeStmt();
    }

    /**
     * @return string
     */
    protected function getSelect()
    {
        if ($this->distinct) {
            return 'SELECT DISTINCT';
        }

        return 'SELECT';
    }

    /**
     * @return string
     */
    protected function getColumns()
    {
        return implode(' , ', $this->columns);
    }

    /**
     * @param bool $distinct
     *
     * @return string
     */
    protected function setDistinct($distinct)
    {
        if ($distinct) {
            return 'COUNT( DISTINCT';
        }

        return 'COUNT(';
    }

    /**
     * @param string|null $as
     *
     * @return string
     */
    protected function setAs($as = null)
    {
        if (empty($as)) {
            return '';
        }

        return ' AS '.$as;
    }
}
