<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\Database;

/**
 * Class UpdateStatement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class UpdateStatement extends StatementContainer
{
    /**
     * Constructor.
     *
     * @param Database $dbh
     * @param array    $pairs
     */
    public function __construct(Database $dbh, array $pairs)
    {
        parent::__construct($dbh);

        $this->set($pairs);
    }

    /**
     * @param $table
     *
     * @return $this
     */
    public function table($table)
    {
        $this->setTable($table);

        return $this;
    }

    /**
     * @param array $pairs
     *
     * @return $this
     */
    public function set(array $pairs)
    {
        foreach ($pairs as $column => $value) {
            $this->columns[] = $column.' = ?';
            $this->values[] = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            trigger_error('No table is set for update', E_USER_ERROR);
        }

        if (empty($this->columns) && empty($this->values)) {
            trigger_error('Missing columns and values for update', E_USER_ERROR);
        }

        $sql = 'UPDATE '.$this->table;
        $sql .= ' SET '.$this->getColumns();
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

    /**
     * @return string
     */
    private function getColumns()
    {
        return implode(' , ', $this->columns);
    }
}
