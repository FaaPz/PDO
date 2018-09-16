<?php

namespace Pb\PDO\Statement;

use Pb\PDO\Database;

class InsertStatement extends StatementContainer
{
    public function __construct(Database $dbh, array $columnsOrPairs)
    {
        parent::__construct($dbh);

        if ($this->isAssociative($columnsOrPairs)) {
            $this->columns(array_keys($columnsOrPairs));
            $this->values(array_values($columnsOrPairs));
        } else {
            $this->columns($columnsOrPairs);
        }
    }

    /**
     * @param string $table
     */
    public function into($table)
    {
        $this->setTable($table);

        return $this;
    }

    public function columns(array $columns)
    {
        $this->setColumns($columns);

        return $this;
    }

    public function values(array $values)
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            trigger_error('No table is set for insertion', E_USER_ERROR);
        }

        if (empty($this->columns)) {
            trigger_error('Missing columns for insertion', E_USER_ERROR);
        }

        if (empty($this->values)) {
            trigger_error('Missing values for insertion', E_USER_ERROR);
        }

        $sql = 'INSERT INTO '.$this->table;
        $sql .= ' '.$this->getColumns();
        $sql .= ' VALUES '.$this->getPlaceholders();

        return $sql;
    }

    /**
     * @param bool $insertId
     *
     * @return string
     */
    public function execute($insertId = true)
    {
        if (! $insertId) {
            return parent::execute();
        }

        parent::execute();

        return $this->dbh->lastInsertId();
    }

    /**
     * @return string
     */
    protected function getColumns()
    {
        return '( `'.implode('` , `', $this->columns).'` )';
    }
}
