<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

/**
 * Class LimitClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class LimitClause extends ClauseContainer
{
    /**
     * @var null
     */
    private $limit = null;

    /**
     * @param $number
     */
    public function limit($number)
    {
        if (is_int($number) && $number >= 0) {
            $this->limit = intval($number);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->limit === null) {
            return '';
        }

        return ' LIMIT '.$this->limit;
    }
}
