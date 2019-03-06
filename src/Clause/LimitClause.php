<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

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
     * @param int $number
     * @param int $offset
     */
    public function limit($number, $offset = 0)
    {
        if (!is_int($number) || (!is_null($offset) && !is_int($offset))) {
            trigger_error('Expects parameters as integers', E_USER_ERROR);
        }

        if (!is_null($offset) && $offset >= 0) {
            $this->limit = intval($number).' OFFSET '.intval($offset);
        } elseif ($number >= 0) {
            $this->limit = intval($number);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_null($this->limit)) {
            return '';
        }

        return ' LIMIT '.$this->limit;
    }
}
