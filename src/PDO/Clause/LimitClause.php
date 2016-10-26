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
     * @var int|null
     */
    private $limit = null;

    /**
     * @param int $number
     * @param int|null $offset
     */
    public function limit($number, $offset = null)
    {
        if (!is_int($number) || !is_int($offset)) {
            trigger_error('Expects parameters as integers', E_USER_ERROR);
        }

        if ($offset !== null && $offset >= 0) {
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
