<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO;

use PDO;
use PDOException;

abstract class AbstractStatement implements QueryInterface
{
    /** @var PDO $dbh */
    protected $dbh;

    /**
     * @param PDO $dbh
     */
    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @throws PDOException
     *
     * @return mixed
     */
    public function execute()
    {
        $stmt = $this->dbh->prepare($this->__toString());

        try {
            $success = $stmt->execute($this->getValues());
            if (!$success) {
                list($state, $code, $message) = $stmt->errorInfo();

                // We are not in exception mode, raise error.
                user_error("SQLSTATE[{$state}] [{$code}] {$message}", E_USER_ERROR);
            }
        } catch (PDOException $e) {
            // We are in exception mode, carry on.
            throw $e;
        }

        return $stmt;
    }
}
