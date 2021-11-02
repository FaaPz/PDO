<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use PDOException;
use PDOStatement;

interface StatementInterface extends QueryInterface
{
    /**
     * @throws PDOException
     *
     * @return PDOStatement|false
     */
    public function execute();
}
