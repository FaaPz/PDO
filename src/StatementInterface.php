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
     * @return PDOStatement|false
     * @throws PDOException
     */
    public function execute();
}
