<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\QueryInterface;

class Limit implements QueryInterface
{
    /** @var int $size */
    protected $size;

    /** @var int|null $offset */
    protected $offset;

    /**
     * @param int      $size
     * @param int|null $offset
     */
    public function __construct(int $size, int $offset = null)
    {
        $this->size = $size;
        $this->offset = $offset;
    }

    /**
     * @return int[]
     */
    public function getValues(): array
    {
        $values = [];
        if (isset($this->offset)) {
            $values[] = $this->offset;
        }
        $values[] = $this->size;

        return $values;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $sql = '?';
        if (isset($this->offset)) {
            $sql .= ', ?';
        }

        return $sql;
    }
}
