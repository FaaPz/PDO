<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

use Slim\PDO\StatementInterface;

/**
 * Class Expression.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Inline implements StatementInterface
{
    /**
     * PDO handle to the database.
     * @var Database $dbh
     */
    protected $dbh;

    /**
     * @var string $expression
     */
    protected $expression;

    /**
     * @var array $values
     */
    protected $values = array();

    /**
     * Constructor.
     *
     * @param Database $dbh
     */
    public function __construct(Database $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @return array
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->column} {$this->operator} ?";
    }
}
