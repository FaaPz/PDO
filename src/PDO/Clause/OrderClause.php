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
     * @param $statement
     * @param string $order
     */
    public function orderBy($statement, $order = 'ASC')
    {
        $this->container[] = $statement.' '.strtoupper($order);
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
