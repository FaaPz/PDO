<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

interface DatabaseInterface
{
    /**
     * @param string            $dsn
     * @param ?string           $username
     * @param ?string           $password
     * @param array<int, mixed> $options
     */
    public function __construct(string $dsn, ?string $username = null, ?string $password = null, array $options = []);
}
