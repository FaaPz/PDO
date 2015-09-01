<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO;

/**
 * Class Statement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Statement extends \PDOStatement
{
    /**
     * @var Database
     */
    protected $dbh;

    /**
     * Constructor.
     *
     * @param Database $dbh
     */
    protected function __construct(Database $dbh)
    {
        $this->dbh = $dbh;
    }
}
