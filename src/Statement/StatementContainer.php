<?php

namespace Pb\PDO\Statement;

use Pb\PDO\Database;
use Pb\PDO\Clause\LimitClause;
use Pb\PDO\Clause\OrderClause;
use Pb\PDO\Clause\WhereClause;

abstract class StatementContainer
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
     * @var array
     */
    protected $placeholdersMulti = [];

    /**
     * @var string
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

    public function __construct(Database $dbh)
    {
        $this->dbh = $dbh;

        $this->whereClause = new WhereClause();
        $this->orderClause = new OrderClause();
        $this->limitClause = new LimitClause();
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     * @param string $chainType
     */
    public function where($column, $operator = null, $value = null, $chainType = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->where($column, $operator, $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $operator
     * @param null   $value
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        $this->values[] = $value;

        $this->whereClause->orWhere($column, $operator);

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     * @param string $chainType
     */
    public function whereBetween($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->whereClause->whereBetween($column, $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     */
    public function orWhereBetween($column, array $values)
    {
        $this->setValues($values);

        $this->whereClause->orWhereBetween($column);

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     * @param string $chainType
     */
    public function whereNotBetween($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->whereClause->whereNotBetween($column, $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     */
    public function orWhereNotBetween($column, array $values)
    {
        $this->setValues($values);

        $this->whereClause->orWhereNotBetween($column);

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     * @param string $chainType
     */
    public function whereIn($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->whereIn($column, $this->getPlaceholders(), $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     */
    public function orWhereIn($column, array $values)
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->orWhereIn($column, $this->getPlaceholders());

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     * @param string $chainType
     */
    public function whereNotIn($column, array $values, $chainType = 'AND')
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->whereNotIn($column, $this->getPlaceholders(), $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param array  $values
     */
    public function orWhereNotIn($column, array $values)
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        $this->whereClause->orWhereNotIn($column, $this->getPlaceholders());

        return $this;
    }

    /**
     * @param string $column
     * @param null   $value
     * @param string $chainType
     */
    public function whereLike($column, $value = null, $chainType = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->whereLike($column, $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $value
     */
    public function orWhereLike($column, $value = null)
    {
        $this->values[] = $value;

        $this->whereClause->orWhereLike($column);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $value
     * @param string $chainType
     */
    public function whereNotLike($column, $value = null, $chainType = 'AND')
    {
        $this->values[] = $value;

        $this->whereClause->whereNotLike($column, $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param null   $value
     */
    public function orWhereNotLike($column, $value = null)
    {
        $this->values[] = $value;

        $this->whereClause->orWhereNotLike($column);

        return $this;
    }

    /**
     * @param string $column
     * @param string $chainType
     */
    public function whereNull($column, $chainType = 'AND')
    {
        $this->whereClause->whereNull($column, $chainType);

        return $this;
    }

    /**
     * @param string $column
     */
    public function orWhereNull($column)
    {
        $this->whereClause->orWhereNull($column);

        return $this;
    }

    /**
     * @param string $column
     * @param string $chainType
     */
    public function whereNotNull($column, $chainType = 'AND')
    {
        $this->whereClause->whereNotNull($column, $chainType);

        return $this;
    }

    /**
     * @param string $column
     */
    public function orWhereNotNull($column)
    {
        $this->whereClause->orWhereNotNull($column);

        return $this;
    }

    /**
     * @param string $columns
     * @param null   $operator
     * @param string $chainType
     */
    public function whereMany($columns, $operator = null, $chainType = 'AND')
    {
        $this->values = array_merge($this->values, array_values($columns));
        $this->whereClause->whereMany(array_keys($columns), $operator, $chainType);

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderClause->orderBy($column, $direction);

        return $this;
    }

    /**
     * @param int $number
     * @param int $offset
     */
    public function limit($number, $offset = 0)
    {
        $this->limitClause->limit($number, $offset);

        return $this;
    }

    /**
     * @return mixed
     */
    abstract public function __toString();

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->dbh->commit();
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        return $this->dbh->rollBack();
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        $stmt = $this->getStatement();
        $this->bindValues($stmt, $this->values);
        $stmt->execute();

        return $stmt;
    }

    /**
     * @return \PDOStatement
     */
    public function executeMulti()
    {
        $stmt = $this->getStatement();
        $this->bindValuesMulti($stmt, $this->values);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Bind values to their parameters in the given statement.
     *
     * @param  \PDOStatement $statement
     * @param  array         $bindings
     */
    protected function bindValues($statement, $bindings)
    {
        foreach ($bindings as $key => $value) {
            $statement->bindValue(
                is_string($key) ? $key : $key + 1,
                $value,
                is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR
            );
        }
    }

    /**
     * Bind values for a multi statement.
     *
     * @param  \PDOStatement $statement
     * @param  array         $bindings
     */
    protected function bindValuesMulti($statement, $bindings)
    {
        // Reduce array to flat values while preserving order
        $values = [];

        foreach ($bindings as $array) {
            $values = array_merge($values, array_values($array));
        }

        return $this->bindValues($statement, $values);
    }

    /**
     * @return string
     */
    public function compile()
    {
        return $this->getStatement()->queryString;
    }

    /**
     * @param string $table
     */
    protected function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    protected function setColumns(array $columns)
    {
        $this->columns = array_merge($this->columns, $columns);

        return $this;
    }

    protected function setValues(array $values)
    {
        $this->values = array_merge($this->values, $values);

        return $this;
    }

    protected function appendValues(array $values)
    {
        $this->values[] = $values;

        return $this;
    }

    /**
     * @return string
     */
    protected function getPlaceholders()
    {
        $placeholders = $this->placeholders;

        $this->placeholders = [];

        return '( '.implode(' , ', $placeholders).' )';
    }

    /**
     * @return string
     */
    protected function getPlaceholdersMulti()
    {
        $result = [];
        $placeholders = $this->placeholdersMulti;

        $this->placeholdersMulti = [];

        foreach ($placeholders as $placeholder) {
            $result[] = '( '.implode(' , ', $placeholder).' )';
        }

        return implode(' , ', $result);
    }

    protected function setPlaceholders(array $values)
    {
        foreach ($values as $value) {
            $this->placeholders[] = $this->setPlaceholder(
                '?',
                is_array($value) || $value instanceof \Countable
                    ? sizeof($value)
                    : 1);
        }
    }

    protected function setMultiPlaceholders(array $values)
    {
        $placeholders = [];

        foreach ($values as $value) {
            $placeholders[] = $this->setPlaceholder(
                '?',
                is_array($value) || $value instanceof \Countable
                    ? sizeof($value)
                    : 1);
        }

        $this->placeholdersMulti[] = $placeholders;
    }

    /**
     * @return bool
     */
    protected function isAssociative(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
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
     * @param string $text
     * @param int    $count
     * @param string $separator
     *
     * @return string
     */
    private function setPlaceholder($text, $count = 0, $separator = ' , ')
    {
        $result = [];

        if ($count > 0) {
            for ($x = 0; $x < $count; ++$x) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }
}
