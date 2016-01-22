<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

/**
 * Class OrderClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class OrderClause extends ClauseContainer
{
    /**
     * @param $column
     * @param string $direction
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->container[] = $column.' '.strtoupper($direction);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->container)) {
            return '';
        }

        return ' ORDER BY '.implode(' , ', $this->container);
    }
}
