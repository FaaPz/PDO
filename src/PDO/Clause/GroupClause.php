<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

/**
 * Class GroupClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class GroupClause extends ClauseContainer
{
    /**
     * @param $statement
     */
    public function groupBy($statement)
    {
        $this->container[] = $statement;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->container)) {
            return '';
        }

        return ' GROUP BY '.implode(' , ', $this->container);
    }
}
