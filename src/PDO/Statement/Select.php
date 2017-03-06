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
 * Class SelectStatement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class SelectStatement extends AbstractStatement
{
    /**
     * @var bool
     */
    private $distinct = false;

    /**
     * @var JoinClause
     */
    private $joinClause;

    /**
     * @var string[]
     */
    private $groupBy;

    /**
     * @var Clause\Conditional[]
     */
    private $having;

    /**
     * @var OffsetClause
     */
    private $offsetClause;

    /**
     * Constructor.
     *
     * @param Database $dbh
     * @param array    $columns
     */
    public function __construct(Database $dbh, array $columns)
    {
        parent::__construct($dbh);

        if (empty($columns)) {
            $columns = array('*');
        }

        $this->setColumns($columns);

        $this->joinClause = new JoinClause();
        $this->groupClause = new GroupClause();
        $this->havingClause = new HavingClause();
        $this->offsetClause = new OffsetClause();
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
     * @param $table
     * @param $first
     * @param null   $operator
     * @param null   $second
     * @param string $type
     *
     * @return $this
     */
    public function join($table, $first, $operator = null, $second = null, $type = 'INNER')
    {
        $this->joinClause->join($table, $first, $operator, $second, $type);

        return $this;
    }

    /**
     * @param $table
     * @param $first
     * @param null $operator
     * @param null $second
     *
     * @return $this
     */
    public function leftJoin($table, $first, $operator = null, $second = null)
    {
        $this->joinClause->leftJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * @param $table
     * @param $first
     * @param null $operator
     * @param null $second
     *
     * @return $this
     */
    public function rightJoin($table, $first, $operator = null, $second = null)
    {
        $this->joinClause->rightJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * @param $table
     * @param $first
     * @param null $operator
     * @param null $second
     *
     * @return $this
     */
    public function fullJoin($table, $first, $operator = null, $second = null)
    {
        $this->joinClause->fullJoin($table, $first, $operator, $second);

        return $this;
    }

    /**
     * @param $column
     *
     * @return $this
     */
    public function groupBy($column)
    {
        $this->groupBy[] = $column;

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

        $sql .= $this->joinClause;

        if (count($this->where) > 0) {
            $sql .= " WHERE " . implode(' ', $this->where);
        }

        if (count($this->groupBy) > 0) {
            $sql .= " GROUP BY " . implode(", ", $this->groupBy);
        }

        if (count($this->having) > 0) {
            $sql .= " HAVING " . implode(' ', $this->having);
        }

        if (count($this->orderBy) > 0) {
            $sql .= " ORDER BY " . implode(", ", $this->orderBy);
        }

        if ($this->limit != null) {
            $sql .= " LIMIT {$this->limit}";
        }

        $sql .= $this->offsetClause;

        return $sql;
    }

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        return parent::execute();
    }

    /**
     * @return string
     */
    private function getColumns()
    {
        if ($this->aggregate) {
            array_splice($this->columns, 0, -1);
        }

        return implode(', ', $this->columns);
    }

    /**
     * @param $as
     *
     * @return string
     */
    private function setAs($as)
    {
        if (empty($as)) {
            return '';
        }

        return ' AS '.$as;
    }
}
