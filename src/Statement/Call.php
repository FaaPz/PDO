<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AbstractStatement;
use FaaPz\PDO\Clause\MethodInterface;
use FaaPz\PDO\Database;

class Call extends AbstractStatement implements CallInterface
{
    /** @var ?MethodInterface $method */
    protected $method = null;


    /**
     * @param Database         $dbh
     * @param ?MethodInterface $procedure
     */
    public function __construct(Database $dbh, ?MethodInterface $procedure = null)
    {
        parent::__construct($dbh);

        if ($procedure != null) {
            $this->method($procedure);
        }
    }

    /**
     * @param MethodInterface $procedure
     *
     * @return self
     */
    public function method(MethodInterface $procedure): self
    {
        $this->method = $procedure;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderMethod(): string
    {
        if ($this->method == null) {
            trigger_error('No method set for call statement', E_USER_ERROR);
        }

        return " {$this->method}";
    }

    /**
     * @return array<mixed>
     */
    public function getValues(): array
    {
        return $this->method->getValues();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'CALL'
            . $this->renderMethod();
    }
}
