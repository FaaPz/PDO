<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\Clause\MethodInterface;
use FaaPz\PDO\StatementInterface;

interface CallInterface extends StatementInterface
{
    /**
     * @param MethodInterface $procedure
     *
     * @return self
     */
    public function method(MethodInterface $procedure);
}
