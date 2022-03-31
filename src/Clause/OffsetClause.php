<?php

namespace Pb\PDO\Clause;

class OffsetClause extends ClauseContainer
{
    /**
     * @var int|null
     */
    private $offset = null;

    /**
     * @param int $number
     *
     * @return void
     */
    public function offset($number)
    {
        if (! is_int($number)) {
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
