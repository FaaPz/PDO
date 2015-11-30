<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\Clause\LimitClause;
use Slim\PDO\Clause\OrderClause;
use Slim\PDO\Clause\WhereClause;
use Slim\PDO\Database;

/**
 * Class Statement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
abstract class StatementContainer
{
    /**
     * @var Database
     */
    protected $dbh;

    /**
     * @var array
     */
    protected $columns = array();

    /**
     * @var array
     */
    protected $values = array();

    /**
     * @var array
     */
    protected $placeholders = array();

    /**
     * @var
     */
    protected $table;

    /**
     * @var WhereClause
     */
    protected $whereClause;

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

        $this->whereClause = new WhereClause();
        $this->orderClause = new OrderClause();
        $this->limitClause = new LimitClause();
    }

    /**
     * @param $column
     * @param null   $operator
     * @param null   $value
     * @param string $rule
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $rule = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->where($column, $operator, $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereBetween($column, array $values, $rule = 'AND')
    {
        $this->setValues($values);

        $this->whereClause->whereBetween($column, $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereNotBetween($column, array $values, $rule = 'AND')
    {
        $this->setValues($values);

        $this->whereClause->whereNotBetween($column, $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereIn($column, array $values, $rule = 'AND')
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->whereIn($column, $this->getPlaceholders(), $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereNotIn($column, array $values, $rule = 'AND')
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->whereNotIn($column, $this->getPlaceholders(), $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereLike($column, $value = null, $rule = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->whereLike($column, $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereNotLike($column, $value = null, $rule = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->whereNotLike($column, $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereNull($column, $rule = 'AND')
    {
        $this->whereClause->whereNull($column, $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereNotNull($column, $rule = 'AND')
    {
        $this->whereClause->whereNotNull($column, $rule);

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
     * @param string $rule
     *
     * @return $this
     */
    public function whereMany($columns, $operator = null, $rule = 'AND')
    {
        $this->values = array_merge($this->values, array_values($columns));
        $this->whereClause->whereMany(array_keys($columns), $operator, $rule);

        return $this;
    }

    /**
     * @param $statement
     * @param string $order
     *
     * @return $this
     */
    public function orderBy($statement, $order = 'ASC')
    {
        $this->orderClause->orderBy($statement, $order);

        return $this;
    }

    /**
     * @param $number
     *
     * @return $this
     */
    public function limit($number, $end = null)
    {
        $this->limitClause->limit($number, $end);

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

        unset($this->placeholders);

        return '( '.implode(' , ', $placeholders).' )';
    }

    /**
     * @param array $values
     */
    protected function setPlaceholders(array $values)
    {
        foreach ($values as $value) {
            $this->placeholders[] = $this->setPlaceholder('?', is_null($value) ? 1 : sizeof($value));
        }
    }

    /**
     * @return \PDOStatement
     */
    private function getStatement()
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
    private function setPlaceholder($text, $count = 0, $separator = ' , ')
    {
        $result = array();

        if ($count > 0) {
            for ($x = 0; $x < $count; ++$x) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }
}
