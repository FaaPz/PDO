<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

interface QueryInterface
{
    /**
     * @return mixed[]
     */
    public function getValues(): array;

    /**
     * @return string
     */
    public function __toString(): string;
}
