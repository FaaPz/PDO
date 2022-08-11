<?php

namespace FaaPz\PDO\Test\UserManager\MariaDB;

use FaaPz\PDO\Definition\User;
use FaaPz\PDO\Definition\DropUser;
use FaaPz\PDO\UserManager\MariaDB\GrantPrivileges;
use FaaPz\PDO\UserManager\MariaDB\RevokePrivileges;
use FaaPz\PDO\UserManager\MariaDB\UserManagerMariaDB;
use FaaPz\PDO\UserManager\UserManagerInterface;
use PDO;
use PHPUnit\Framework\TestCase;

class UserManagerMariaDBTest extends TestCase
{
    private UserManagerInterface $userManager;
    private PDO $subject;
    private string $host = 'localhost';
    private string $user = 'user';
    private string $password = 'pass';
    private string $database = 'db';
    private string $table = 'tb';

    public function setUp(): void
    {
        $this->subject = $this->createMock(PDO::class);

        $this->userManager = new UserManagerMariaDB();
    }

    public function testIfInstanceIsFromCreateUser()
    {
        $createUser = $this->userManager->createUser($this->subject, $this->host, $this->user, $this->password);

        $this->assertInstanceOf(User::class, $createUser);
    }

    public function testIfInstanceIsFromDropUser()
    {
        $dropUser = $this->userManager->dropUser($this->subject, $this->host, $this->user);

        $this->assertInstanceOf(DropUser::class, $dropUser);
    }

    public function testIfInstanceIsFromRovokePrivileges()
    {
        $revokeUser = $this->userManager->revokePrivileges($this->subject, $this->host, $this->user, $this->database, $this->table);

        $this->assertInstanceOf(RevokePrivileges::class, $revokeUser);
        
    }

    public function testIfInstanceIsFromGrantPrivileges()
    {
        $grantUser = $this->userManager->grantPrivileges($this->subject, $this->host, $this->user, $this->password, $this->database, $this->table);

        $this->assertInstanceOf(GrantPrivileges::class, $grantUser);
    }
}