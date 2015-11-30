<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

/**
 * Class WhereClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class WhereClause extends ClauseContainer
{
    /**
     * @param $column
     * @param null   $operator
     * @param string $rule
     */
    public function where($column, $operator = null, $rule = 'AND')
    {
        $this->container[] = ' '.$rule.' '.$column.' '.$operator.' ?';
    }

    /**
     * @param $column
     * @param null $operator
     */
    public function orWhere($column, $operator = null)
    {
        $this->where($column, $operator, 'OR');
    }

    /**
     * @param $column
     * @param string $rule
     * @param bool   $not
     */
    public function whereBetween($column, $rule = 'AND', $not = false)
    {
        $syntax = 'BETWEEN';

        if ($not) {
            $syntax = 'NOT BETWEEN';
        }

        $this->container[] = ' '.$rule.' '.$column.' '.$syntax.' ? AND ?';
    }

    /**
     * @param $column
     */
    public function orWhereBetween($column)
    {
        $this->whereBetween($column, 'OR');
    }

    /**
     * @param $column
     * @param string $rule
     */
    public function whereNotBetween($column, $rule = 'AND')
    {
        $this->whereBetween($column, $rule, true);
    }

    /**
     * @param $column
     */
    public function orWhereNotBetween($column)
    {
        $this->whereNotBetween($column, 'OR');
    }

    /**
     * @param $column
     * @param $placeholders
     * @param string $rule
     * @param bool   $not
     */
    public function whereIn($column, $placeholders, $rule = 'AND', $not = false)
    {
        $syntax = 'IN';

        if ($not) {
            $syntax = 'NOT IN';
        }

        $this->container[] = ' '.$rule.' '.$column.' '.$syntax.' '.$placeholders;
    }

    /**
     * @param $column
     * @param $placeholders
     */
    public function orWhereIn($column, $placeholders)
    {
        $this->whereIn($column, $placeholders, 'OR');
    }

    /**
     * @param $column
     * @param $placeholders
     * @param string $rule
     */
    public function whereNotIn($column, $placeholders, $rule = 'AND')
    {
        $this->whereIn($column, $placeholders, $rule, true);
    }

    /**
     * @param $column
     * @param $placeholders
     */
    public function orWhereNotIn($column, $placeholders)
    {
        $this->whereNotIn($column, $placeholders, 'OR');
    }

    /**
     * @param $column
     * @param string $rule
     * @param bool   $not
     */
    public function whereLike($column, $rule = 'AND', $not = false)
    {
        $syntax = 'LIKE';

        if ($not) {
            $syntax = 'NOT LIKE';
        }

        $this->container[] = ' '.$rule.' '.$column.' '.$syntax.' ?';
    }

    /**
     * @param $column
     */
    public function orWhereLike($column)
    {
        $this->whereLike($column, 'OR');
    }

    /**
     * @param $column
     * @param string $rule
     */
    public function whereNotLike($column, $rule = 'AND')
    {
        $this->whereLike($column, $rule, true);
    }

    /**
     * @param $column
     */
    public function orWhereNotLike($column)
    {
        $this->whereNotLike($column, 'OR');
    }

    /**
     * @param $column
     * @param string $rule
     * @param bool   $not
     */
    public function whereNull($column, $rule = 'AND', $not = false)
    {
        $syntax = 'NULL';

        if ($not) {
            $syntax = 'NOT NULL';
        }

        $this->container[] = ' '.$rule.' '.$column.' IS '.$syntax;
    }

    /**
     * @param $column
     */
    public function orWhereNull($column)
    {
        $this->whereNull($column, 'OR');
    }

    /**
     * @param $column
     * @param string $rule
     */
    public function whereNotNull($column, $rule = 'AND')
    {
        $this->whereNull($column, $rule, true);
    }

    /**
     * @param $column
     */
    public function orWhereNotNull($column)
    {
        $this->whereNotNull($column, 'OR');
    }

    /**
     * @param $columns
     * @param null   $operator
     * @param string $rule
     */
    public function whereMany($columns, $operator = null, $rule = 'AND')
    {
        foreach ($columns as $column) {
            $this->container[] = ' '.$rule.' '.$column.' '.$operator.' ?';
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

        $args = array();

        foreach ($this->container as $where) {
            $args[] = $where;
        }

        return ' WHERE '.ltrim(implode('', $args), 'AND ');
    }
}
