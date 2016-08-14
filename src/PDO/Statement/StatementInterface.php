<?php
/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Statement;

use Slim\PDO\Database;

/**
 * Interface StatementInterface.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
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
