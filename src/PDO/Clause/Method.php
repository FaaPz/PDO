<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

use Slim\PDO\StatementInterface;

class Method implements StatementInterface
{
    /** @var string $expression */
    protected $name;

    /** @var array $values */
    protected $values;

    /**
     * @param string $name
     * @param array $values
     */
    public function __construct($name, array $values = [])
    {
        $this->name = strtoupper($name);
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $placeholders = rtrim(str_repeat("?, ", count($this->values)), ", ");
        return "{$this->name}({$placeholders})";
    }
}
