<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\StatementInterface;

interface DeleteInterface extends StatementInterface
{
    /**
     * @param string|array<string, string> $table
     *
     * @return static
     */
    public function from($table);
}
