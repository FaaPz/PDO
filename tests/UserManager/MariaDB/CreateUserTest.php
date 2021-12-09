<?php

namespace FaaPz\PDO\Test\UserManager\MariaDB;

use PHPUnit\Framework\TestCase;
use PDO;
use FaaPz\PDO\UserManager\MariaDB\CreateUser;

class CreateUserTest extends TestCase
{
 
    public function testExceptionIfNotExistsAndOrReplaceTogether()
    {
        $this->expectException(\Exception::class);

        $user = 'bob';
        $host = 'localhost';
        $password = '';

        $subject = new CreateUser(
            
            $this->createMock(PDO::class),
            $host,
            $user,
            $password
        );

        $sql = $subject->orReplace()->ifNotExists()->__toString();

    }

    public function testCreateUser()
    {
        $user = 'bob';
        $host = 'localhost';
        $password = '';

        $subject = new CreateUser(
            
            $this->createMock(PDO::class),
            $host,
            $user,
            $password
        );

        $sql = $subject->__toString();

        $expect = "CREATE USER {$user}@{$host}";

        $this->assertEquals($expect, $sql);
    }

    public function testCreateUserWithPassword()
    {
        $user = 'bob';
        $host = 'localhost';
        $password = '123';

        $subject = new CreateUser(
            
            $this->createMock(PDO::class),
            $host,
            $user,
            $password
        );

        $sql = $subject->__toString();

        $expect = "CREATE USER {$user}@{$host} IDENTIFIED BY '{$password}'";

        $this->assertEquals($expect, $sql);
    }    
    
    public function testCreateUserWithOrReplace()
    {
        $user = 'bob';
        $host = 'localhost';
        $password = '';

        $subject = new CreateUser(
            
            $this->createMock(PDO::class),
            $host,
            $user,
            $password
        );

        $sql = $subject->orReplace()->__toString();

        $expect = "CREATE OR REPLACE USER {$user}@{$host}";

        $this->assertEquals($expect, $sql);
    }

    public function testCreateUserWithIfNotExists()
    {
        $user = 'bob';
        $host = 'localhost';
        $password = '';

        $subject = new CreateUser(
            
            $this->createMock(PDO::class),
            $host,
            $user,
            $password
        );

        $sql = $subject->ifNotExists()->__toString();

        $expect = "CREATE USER IF NOT EXISTS {$user}@{$host}";

        $this->assertEquals($expect, $sql);
    }

    public function testCreateUserWithOrReplaceAndPassword()
    {
        $user = 'bob';
        $host = 'localhost';
        $password = '123';

        $subject = new CreateUser(
            
            $this->createMock(PDO::class),
            $host,
            $user,
            $password
        );

        $sql = $subject->orReplace()->__toString();

        $expect = "CREATE OR REPLACE USER {$user}@{$host} IDENTIFIED BY '{$password}'";

        $this->assertEquals($expect, $sql);
    }

    public function testCreateUserWithIfNotExistsAndPassword()
    {
        $user = 'bob';
        $host = 'localhost';
        $password = '123';

        $subject = new CreateUser(
            
            $this->createMock(PDO::class),
            $host,
            $user,
            $password
        );

        $sql = $subject->ifNotExists()->__toString();

        $expect = "CREATE USER IF NOT EXISTS {$user}@{$host} IDENTIFIED BY '{$password}'";

        $this->assertEquals($expect, $sql);
    }
}