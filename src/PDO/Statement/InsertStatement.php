<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Statement;

use Slim\PDO\Database;

/**
 * Class InsertStatement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class InsertStatement extends StatementContainer
{
    /**
     * Constructor.
     *
     * @param Database $dbh
     * @param array    $columnsOrPairs
     */
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
     * @param $table
     *
     * @return $this
     */
    public function into($table)
    {
        $this->setTable($table);

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->setColumns($columns);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function values(array $values)
    {
        $this->setValues($values);

        $this->setPlaceholders($values);

        return $this;
    }

    private $_updateOnDuplicate = false;
    private $_updateValues = [];
    private $_updateFields = [];

    /**
     * @param array $fieldValues( field => value )
     *
     * @return $this
     */
    public function updateOnDuplicate(array $fieldValues)
    {
        if (!empty($fieldValues)) {
            $this->_updateOnDuplicate = true;
            $this->_updateValues = array_values($fieldValues);
            $this->_updateFields = array_keys($fieldValues);
        }

        return $this;
    }

    /**
     * Internal function.
     *
     * @return string = Prepared update fields
     */
    protected function _prepareUpdateFields()
    {
        $this->setValues($this->_updateValues);

        $str = '';
        $commaFlag = false;
        foreach ($this->_updateFields as $field) {
            if ($commaFlag) {
                $str .= ', ';
            }
            $str .= $field.' = ?';
            $commaFlag = true;
        }

        return $str;
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

        if ($this->_updateOnDuplicate) {
            $sql .= ' ON DUPLICATE KEY UPDATE '.$this->_prepareUpdateFields();
        }

        return $sql;
    }

    /**
     * @param bool $insertId
     *
     * @return string
     */
    public function execute($insertId = true)
    {
        if (!$insertId) {
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
        return '( '.implode(' , ', $this->columns).' )';
    }
}
