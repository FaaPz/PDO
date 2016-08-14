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
     * @param string $chainType
     */
    public function where($column, $operator = null, $chainType = 'AND')
    {
        $this->container[] = ' '.$chainType.' '.$column.' '.$operator.' ?';
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
     * @param string $chainType
     * @param bool   $not
     */
    public function whereBetween($column, $chainType = 'AND', $not = false)
    {
        $syntax = 'BETWEEN';

        if ($not) {
            $syntax = 'NOT BETWEEN';
        }

        $this->container[] = ' '.$chainType.' '.$column.' '.$syntax.' ? AND ?';
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
     * @param string $chainType
     */
    public function whereNotBetween($column, $chainType = 'AND')
    {
        $this->whereBetween($column, $chainType, true);
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
     * @param string $chainType
     * @param bool   $not
     */
    public function whereIn($column, $placeholders, $chainType = 'AND', $not = false)
    {
        $syntax = 'IN';

        if ($not) {
            $syntax = 'NOT IN';
        }

        $this->container[] = ' '.$chainType.' '.$column.' '.$syntax.' '.$placeholders;
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
     * @param string $chainType
     */
    public function whereNotIn($column, $placeholders, $chainType = 'AND')
    {
        $this->whereIn($column, $placeholders, $chainType, true);
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
     * @param string $chainType
     * @param bool   $not
     */
    public function whereLike($column, $chainType = 'AND', $not = false)
    {
        $syntax = 'LIKE';

        if ($not) {
            $syntax = 'NOT LIKE';
        }

        $this->container[] = ' '.$chainType.' '.$column.' '.$syntax.' ?';
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
     * @param string $chainType
     */
    public function whereNotLike($column, $chainType = 'AND')
    {
        $this->whereLike($column, $chainType, true);
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
     * @param string $chainType
     * @param bool   $not
     */
    public function whereNull($column, $chainType = 'AND', $not = false)
    {
        $syntax = 'NULL';

        if ($not) {
            $syntax = 'NOT NULL';
        }

        $this->container[] = ' '.$chainType.' '.$column.' IS '.$syntax;
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
     * @param string $chainType
     */
    public function whereNotNull($column, $chainType = 'AND')
    {
        $this->whereNull($column, $chainType, true);
    }

    /**
     * @param $column
     */
    public function orWhereNotNull($column)
    {
        $this->whereNotNull($column, 'OR');
    }

    /**
     * @param array  $columns
     * @param null   $operator
     * @param string $chainType
     */
    public function whereMany(array $columns, $operator = null, $chainType = 'AND')
    {
        foreach ($columns as $column) {
            $this->container[] = ' '.$chainType.' '.$column.' '.$operator.' ?';
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

        return ' WHERE '.ltrim(implode('', $args), ' AND');
    }
}
