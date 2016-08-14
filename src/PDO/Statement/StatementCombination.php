<?php
/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

class StatementCombination extends StatementContainer
{
    public function __toString()
    {
        // Remove `WHERE` prefix in whereClause string
        $sql = substr(trim($this->whereClause), 5);

        return '('.trim($sql).')';
    }
}
