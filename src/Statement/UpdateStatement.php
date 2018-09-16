<?php

namespace Pb\PDO\Statement;

use Pb\PDO\Database;

class UpdateStatement extends StatementContainer
{
    public function __construct(Database $dbh, array $pairs)
    {
        parent::__construct($dbh);

        $this->set($pairs);
    }

    /**
     * @param string $table
     */
    public function table($table)
    {
        $this->setTable($table);

        return $this;
    }

    /**
     * @param array $pairs
     */
    public function set(array $pairs)
    {
        foreach ($pairs as $column => $value) {
            $this->columns[] = "`$column` = ?";
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
    protected function getColumns()
    {
        return implode(' , ', $this->columns);
    }
}
