<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

class Parenthesis extends Conditional
{

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '('.parent::__toString().')';
    }
}