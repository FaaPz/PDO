<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\Clause\JoinClause;
use Slim\PDO\Clause\LimitClause;
use Slim\PDO\Clause\OrderClause;
use Slim\PDO\Clause\WhereClause;
use Slim\PDO\Database;

/**
 * Class Statement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
abstract class StatementContainer implements StatementInterface
{
    /**
     * @var Database
     */
    protected $dbh;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $placeholders = [];

    /**
     * @var
     */
    protected $table;

    /**
     * @var WhereClause
     */
    protected $whereClause;

    /**
     * @var JoinClause
     */
    protected $joinClause;

    /**
     * @var OrderClause
     */
    protected $orderClause;

    /**
     * @var LimitClause
     */
    protected $limitClause;

    /**
     * Constructor.
     *
     * @param Database $dbh
     */
    public function __construct(Database $dbh)
    {
        $this->dbh = $dbh;

        $this->joinClause = new JoinClause();
        $this->whereClause = new WhereClause();
        $this->orderClause = new OrderClause();
        $this->limitClause = new LimitClause();
    }

    /**
     * @param $column
     * @param null   $operator
     * @param null   $value
     * @param string $chainType
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $chainType = 'AND')
    {
        if ($column instanceof StatementCombination) {
            $this->setValues($column->values);
        } else {
            $this->values[] = $value;
        }

        $this->whereClause->where($column, $operator, $chainType);

        return $this;
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     *
     * @return $this
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->whereClause->orWhere($column, $operator);

        return $this;
    }

    /**
     * @param $column
     * @param array  $values
     * @param string $chainType
     *
     * @return $this
     */
    public function whereBetween($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->whereClause->whereBetween($column, $chainType);

        return $this;
    }

    /**
     * @param $column
     * @param array $values
     *
     * @return $this
     */
    public function orWhereBetween($column, array $values)
    {
        $this->setValues($values);

        $this->whereClause->orWhereBetween($column);

        return $this;
    }

    /**
     * @param $column
     * @param array  $values
     * @param string $chainType
     *
     * @return $this
     */
    public function whereNotBetween($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->whereClause->whereNotBetween($column, $chainType);

        return $this;
    }

    /**
     * @param $column
     * @param array $values
     *
     * @return $this
     */
    public function orWhereNotBetween($column, array $values)
    {
        $this->setValues($values);

        $this->whereClause->orWhereNotBetween($column);

        return $this;
    }

    /**
     * @param $column
     * @param array  $values
     * @param string $chainType
     *
     * @return $this
     */
    public function whereIn($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->whereIn($column, $this->getPlaceholders(), $chainType);

        return $this;
    }

    /**
     * @param $column
     * @param array $values
     *
     * @return $this
     */
    public function orWhereIn($column, array $values)
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->orWhereIn($column, $this->getPlaceholders());

        return $this;
    }

    /**
     * @param $column
     * @param array  $values
     * @param string $chainType
     *
     * @return $this
     */
    public function whereNotIn($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->whereNotIn($column, $this->getPlaceholders(), $chainType);

        return $this;
    }

    /**
     * @param $column
     * @param array $values
     *
     * @return $this
     */
    public function orWhereNotIn($column, array $values)
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->orWhereNotIn($column, $this->getPlaceholders());

        return $this;
    }

    /**
     * @param $column
     * @param null   $value
     * @param string $chainType
     *
     * @return $this
     */
    public function whereLike($column, $value = null, $chainType = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->whereLike($column, $chainType);

        return $this;
    }

    /**
     * @param $column
     * @param null $value
     *
     * @return $this
     */
    public function orWhereLike($column, $value = null)
    {
        $this->values[] = $value;

        $this->whereClause->orWhereLike($column);

        return $this;
    }

    /**
     * @param $column
     * @param null   $value
     * @param string $chainType
     *
     * @return $this
     */
    public function whereNotLike($column, $value = null, $chainType = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->whereNotLike($column, $chainType);

        return $this;
    }

    /**
     * @param $column
     * @param null $value
     *
     * @return $this
     */
    public function orWhereNotLike($column, $value = null)
    {
        $this->values[] = $value;

        $this->whereClause->orWhereNotLike($column);

        return $this;
    }

    /**
     * @param $column
     * @param string $chainType
     *
     * @return $this
     */
    public function whereNull($column, $chainType = 'AND')
    {
        $this->whereClause->whereNull($column, $chainType);

        return $this;
    }

    /**
     * @param $column
     *
     * @return $this
     */
    public function orWhereNull($column)
    {
        $this->whereClause->orWhereNull($column);

        return $this;
    }

    /**
     * @param $column
     * @param string $chainType
     *
     * @return $this
     */
    public function whereNotNull($column, $chainType = 'AND')
    {
        $this->whereClause->whereNotNull($column, $chainType);

        return $this;
    }

    /**
     * @param $column
     *
     * @return $this
     */
    public function orWhereNotNull($column)
    {
        $this->whereClause->orWhereNotNull($column);

        return $this;
    }

    /**
     * @param $columns
     * @param null   $operator
     * @param string $chainType
     *
     * @return $this
     */
    public function whereMany($columns, $operator = null, $chainType = 'AND')
    {
        $this->values = array_merge($this->values, array_values($columns));
        $this->whereClause->whereMany(array_keys($columns), $operator, $chainType);

        return $this;
    }

    /**
     * @param $table
     * @param $first
     * @param null   $operator
     * @param null   $second
     * @param string $joinType
     *
     * @return $this
     */
    public function join($table, $first, $operator = null, $second = null, $joinType = 'INNER')
    {
        $this->joinClause->join($table, $first, $operator, $second, $joinType);

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
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderClause->orderBy($column, $direction);

        return $this;
    }

    /**
     * @param $number
     * @param null $offset
     *
     * @return $this
     */
    public function limit($number, $offset = null)
    {
        $this->limitClause->limit($number, $offset);

        return $this;
    }

    /**
     * @return mixed
     */
    abstract public function __toString();

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        $stmt = $this->getStatement();
        $stmt->execute($this->values);

        return $stmt;
    }

    /**
     * @return string
     */
    public function compile()
    {
        return $this->getStatement()->queryString;
    }

    /**
     * @param $table
     *
     * @return $this
     */
    protected function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    protected function setColumns(array $columns)
    {
        $this->columns = array_merge($this->columns, $columns);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    protected function setValues(array $values)
    {
        $this->values = array_merge($this->values, $values);

        return $this;
    }

    /**
     * @return string
     */
    protected function getPlaceholders()
    {
        $placeholders = $this->placeholders;

        reset($this->placeholders);

        return '( '.implode(' , ', $placeholders).' )';
    }

    /**
     * @param array $values
     */
    protected function setPlaceholders(array $values)
    {
        foreach ($values as $value) {
            $this->placeholders[] = $this->setPlaceholder('?', is_null($value) ? 1 : count($value));
        }
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    protected function isAssociative(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @return \PDOStatement
     */
    protected function getStatement()
    {
        $sql = $this;

        return $this->dbh->prepare($sql);
    }

    /**
     * @param $text
     * @param int    $count
     * @param string $separator
     *
     * @return string
     */
    protected function setPlaceholder($text, $count = 0, $separator = ' , ')
    {
        $result = [];

        if ($count > 0) {
            for ($x = 0; $x < $count; ++$x) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }

    /**
     * @return StatementCombination
     */
    public function combine()
    {
        $stmt = new StatementCombination($this->dbh);

        return $stmt;
    }
}
