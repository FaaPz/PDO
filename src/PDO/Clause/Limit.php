<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

use Slim\PDO\StatementInterface;

/**
 * Class Limit.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Limit implements StatementInterface
{
    /** @var int $rowCount */
    protected $rowCount;

    /** @var int|null $offset */
    protected $offset;

    /**
     * Conditional constructor.
     * @param int $rowCount
     * @param int|null $offset
     */
    public function __construct($rowCount, $offset = null)
    {
        $this->rowCount = $rowCount;
        $this->offset = $offset;
    }

    /**
     * @return int[]
     */
    public function getValues()
    {
        $values = array();

        if (isset($this->offset)) {
            $values[] = $this->offset;
        }

        $values[] = $this->rowCount;

        return $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $sql = "";

        if (isset($this->offset)) {
            $sql = "?, ";
        }

        $sql .= "?";

        return $sql;
    }
}
