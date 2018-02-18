<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO;

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
