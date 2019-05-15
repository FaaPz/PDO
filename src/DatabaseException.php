<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use Exception;
use RuntimeException;

class DatabaseException extends RuntimeException
{
    /** @var string $code */
    protected $code;

    /**
     * @param string    $message
     * @param string    $code
     * @param Exception $previous
     */
    public function __construct($message = '', $code = 'database_error', Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->code = $code;
    }
}
