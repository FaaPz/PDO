<?php
/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\Database;

/**
 * Class DeleteStatement
 *
 * @package Slim\PDO\Statement
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class DeleteStatement extends StatementContainer
{
    /**
     * Constructor
     *
     * @param Database $dbh
     */
    public function __construct( Database $dbh )
    {
        parent::__construct( $dbh );
    }

    /**
     * @param $table
     * @return $this
     */
    public function from( $table )
    {
        $this->setTable( $table );

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if( empty( $this->table ) )
        {
            trigger_error( 'No table is set for deletion' , E_USER_ERROR );
        }

        $sql  = 'DELETE FROM ' . $this->table;
        $sql .= $this->whereClause;
        $sql .= $this->orderClause;
        $sql .= $this->limitClause;

        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        return parent::execute()->rowCount();
    }
}
