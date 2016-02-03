<?php
/**
 * Created by PhpStorm.
 * User: abarker
 * Date: 2/2/16
 * Time: 4:14 PM
 */

namespace Slim\PDO\Statement;

use Slim\PDO\Database;

interface StatementInterface
{
    /**
     * Constructor.
     *
     * @param Database $dbh
     */
    public function __construct(Database $dbh);

    /**
     * @return string
     */
    public function __toString();
}
