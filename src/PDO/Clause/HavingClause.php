<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Clause;

/**
 * Class HavingClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class HavingClause extends ClauseContainer
{
    /**
     * @param $column
     * @param null   $operator
     * @param string $chainType
     */
    public function having($column, $operator = null, $chainType = 'AND')
    {
        $this->container[] = ' '.$chainType.' '.$column.' '.$operator.' ?';
    }

    /**
     * @param $column
     * @param null $operator
     */
    public function orHaving($column, $operator = null)
    {
        $this->having($column, $operator, 'OR');
    }

    /**
     * @param $column
     * @param null $operator
     */
    public function havingCount($column, $operator = null)
    {
        $column = 'COUNT( '.$column.' )';

        $this->having($column, $operator);
    }

    /**
     * @param $column
     * @param null $operator
     */
    public function havingMax($column, $operator = null)
    {
        $column = 'MAX( '.$column.' )';

        $this->having($column, $operator);
    }

    /**
     * @param $column
     * @param null $operator
     */
    public function havingMin($column, $operator = null)
    {
        $column = 'MIN( '.$column.' )';

        $this->having($column, $operator);
    }

    /**
     * @param $column
     * @param null $operator
     */
    public function havingAvg($column, $operator = null)
    {
        $column = 'AVG( '.$column.' )';

        $this->having($column, $operator);
    }

    /**
     * @param $column
     * @param null $operator
     */
    public function havingSum($column, $operator = null)
    {
        $column = 'SUM( '.$column.' )';

        $this->having($column, $operator);
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

        foreach ($this->container as $having) {
            $args[] = $having;
        }

        return ' HAVING '.ltrim(implode('', $args), ' AND');
    }
}
