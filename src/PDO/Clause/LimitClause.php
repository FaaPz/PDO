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
     * @param null $offset
     */
    public function limit($number, $offset = null)
    {
        if (is_int($number)) {
            if (is_int($offset) && $offset >= 0) {
                $this->limit = intval($offset).' , '.intval($number);
            } elseif ($number >= 0) {
                $this->limit = intval($number);
            }
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
