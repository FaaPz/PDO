<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

interface StatementInterface
{
    /**
     * @return array
     */
    public function getValues();

    /**
     * @return string
     */
    public function __toString();
}
