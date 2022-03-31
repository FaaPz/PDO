<?php

namespace Pb\PDO\Clause;

class WhereClause extends ClauseContainer
{
    /**
     * @param string      $column
     * @param string|null $operator
     * @param string      $chainType
     *
     * @return void
     */
    public function where($column, $operator = null, $chainType = 'AND')
    {
        $this->container[] = " $chainType `$column` $operator ?";
    }

    /**
     * @param string      $column
     * @param string|null $operator
     *
     * @return void
     */
    public function orWhere($column, $operator = null)
    {
        $this->where($column, $operator, 'OR');
    }

    /**
     * @param string $column
     * @param string $chainType
     * @param bool   $not
     *
     * @return void
     */
    public function whereBetween($column, $chainType = 'AND', $not = false)
    {
        $syntax = 'BETWEEN';

        if ($not) {
            $syntax = 'NOT BETWEEN';
        }

        $this->container[] = " $chainType `$column` $syntax ? AND ?";
    }

    /**
     * @param string $column
     *
     * @return void
     */
    public function orWhereBetween($column)
    {
        $this->whereBetween($column, 'OR');
    }

    /**
     * @param string $column
     * @param string $chainType
     *
     * @return void
     */
    public function whereNotBetween($column, $chainType = 'AND')
    {
        $this->whereBetween($column, $chainType, true);
    }

    /**
     * @param string $column
     *
     * @return void
     */
    public function orWhereNotBetween($column)
    {
        $this->whereNotBetween($column, 'OR');
    }

    /**
     * @param string $column
     * @param string $placeholders
     * @param string $chainType
     * @param bool   $not
     *
     * @return void
     */
    public function whereIn($column, $placeholders, $chainType = 'AND', $not = false)
    {
        $syntax = 'IN';

        if ($not) {
            $syntax = 'NOT IN';
        }

        $this->container[] = " $chainType `$column` $syntax $placeholders";
    }

    /**
     * @param string $column
     * @param string $placeholders
     *
     * @return void
     */
    public function orWhereIn($column, $placeholders)
    {
        $this->whereIn($column, $placeholders, 'OR');
    }

    /**
     * @param string $column
     * @param string $placeholders
     * @param string $chainType
     *
     * @return void
     */
    public function whereNotIn($column, $placeholders, $chainType = 'AND')
    {
        $this->whereIn($column, $placeholders, $chainType, true);
    }

    /**
     * @param string $column
     * @param string $placeholders
     *
     * @return void
     */
    public function orWhereNotIn($column, $placeholders)
    {
        $this->whereNotIn($column, $placeholders, 'OR');
    }

    /**
     * @param string $column
     * @param string $chainType
     * @param bool   $not
     *
     * @return void
     */
    public function whereLike($column, $chainType = 'AND', $not = false)
    {
        $syntax = 'LIKE';

        if ($not) {
            $syntax = 'NOT LIKE';
        }

        $this->container[] = " $chainType `$column` $syntax ?";
    }

    /**
     * @param string $column
     *
     * @return void
     */
    public function orWhereLike($column)
    {
        $this->whereLike($column, 'OR');
    }

    /**
     * @param string $column
     * @param string $chainType
     *
     * @return void
     */
    public function whereNotLike($column, $chainType = 'AND')
    {
        $this->whereLike($column, $chainType, true);
    }

    /**
     * @param string $column
     *
     * @return void
     */
    public function orWhereNotLike($column)
    {
        $this->whereNotLike($column, 'OR');
    }

    /**
     * @param string $column
     * @param string $chainType
     * @param bool   $not
     *
     * @return void
     */
    public function whereNull($column, $chainType = 'AND', $not = false)
    {
        $syntax = 'NULL';

        if ($not) {
            $syntax = 'NOT NULL';
        }

        $this->container[] = " $chainType `$column` IS $syntax";
    }

    /**
     * @param string $column
     *
     * @return void
     */
    public function orWhereNull($column)
    {
        $this->whereNull($column, 'OR');
    }

    /**
     * @param string $column
     * @param string $chainType
     *
     * @return void
     */
    public function whereNotNull($column, $chainType = 'AND')
    {
        $this->whereNull($column, $chainType, true);
    }

    /**
     * @param string $column
     *
     * @return void
     */
    public function orWhereNotNull($column)
    {
        $this->whereNotNull($column, 'OR');
    }

    /**
     * @param string|null $operator
     * @param string      $chainType
     *
     * @return void
     */
    public function whereMany(array $columns, $operator = null, $chainType = 'AND')
    {
        foreach ($columns as $column) {
            $this->container[] = " $chainType `$column` $operator ?";
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->container)) {
            return '';
        }

        $args = [];

        foreach ($this->container as $where) {
            $args[] = $where;
        }

        return ' WHERE '.ltrim(implode('', $args), ' AND');
    }
}
