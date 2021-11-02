<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

class Raw implements RawInterface
{
    /** @var string $sql */
    protected $sql;

    /**
     * @param string $sql
     */
    public function __construct(string $sql)
    {
        $this->sql = $sql;
    }

    /**
     * @return array<mixed>
     */
    public function getValues(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->sql;
    }
}
