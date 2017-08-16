<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO;

use RuntimeException;
use Throwable;

class Exception extends RuntimeException
{
    /**
     * @var string $code
     */
    protected $code;

    /**
     * @param string $message
     * @param string $code
     * @param Throwable $previous
     */
    public function __construct($message = "", $code = "error", Throwable $previous = null) {
        parent::__construct($message, 0, $previous);
        $this->code = $code;
    }
}