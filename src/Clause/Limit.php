<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\StatementInterface;

class Limit implements StatementInterface
{
    /** @var int $rowCount */
    protected $rowCount;

    /** @var int|null $offset */
    protected $offset;

    /**
     * @param int      $rowCount
     * @param int|null $offset
     */
    public function __construct($rowCount, $offset = null)
    {
        $this->rowCount = $rowCount;
        $this->offset = $offset;
    }

    /**
     * @return int[]
     */
    public function getValues()
    {
        $values = [];

        if (isset($this->offset)) {
            $values[] = $this->offset;
        }

        $values[] = $this->rowCount;

        return $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $sql = '';

        if (isset($this->offset)) {
            $sql = '?, ';
        }

        $sql .= '?';

        return $sql;
    }
}
