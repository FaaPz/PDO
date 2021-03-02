<?php
/**
 *  For the grant and revoke commands to work correctly, 
 * you must start the application with super user (root), 
 * that is, 'sudo php index.php'. 
 */
namespace FaaPz\PDO\UserManager\MariaDB;

use PDO;
use FaaPz\PDO\UserManager\UserManagerInterface;

class UserManagerMariaDB implements UserManagerInterface
{
    public function __construct()
    {     
    }

    public function createUser(PDO $pdo, string $host, string $user, ?string $password = ''): CreateUser
    {
        return new CreateUser($pdo, $host, $user, $password); 
    }

    public function dropUser(PDO $pdo, string $host, string $user): DropUser
    {
        return new DropUser($pdo, $host, $user);
    }

    
    public function grantPrivileges(PDO $pdo, string $host, string $user, ?string $password = '', ?string $database = '', ?string $table = ''): GrantPrivileges
    {
        return new GrantPrivileges($pdo, $host, $user, $password, $database, $table);
    }

    
    public function revokePrivileges(PDO $pdo, string $host, string $user, ?string $database = '', ?string $table = ''): RevokePrivileges
    {
        return new RevokePrivileges($pdo, $host, $user, $database, $table);
    }
    
}