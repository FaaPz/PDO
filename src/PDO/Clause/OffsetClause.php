<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Clause;

/**
 * Class OffsetClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class OffsetClause extends ClauseContainer
{
    /**
     * @var null
     */
    private $offset = null;

    /**
     * @param $number
     */
    public function offset($number)
    {
        if (!is_int($number)) {
            trigger_error('Expects parameter as integer', E_USER_ERROR);
        }

        if ($number >= 0) {
            $this->offset = intval($number);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_null($this->offset)) {
            return '';
        }

        return ' OFFSET '.$this->offset;
    }
}
