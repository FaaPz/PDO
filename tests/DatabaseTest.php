<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class DatabaseTest extends TestCase
{
    /** @var Database $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $ref = new ReflectionClass(Database::class);
        $this->subject = $ref->newInstanceWithoutConstructor();
    }

    public function testSelect()
    {
        $this->assertInstanceOf(
            Statement\Select::class,
            $this->subject->select()
        );
    }

    public function testInsert()
    {
        $this->assertInstanceOf(
            Statement\Insert::class,
            $this->subject->insert()
        );
    }

    public function testUpdate()
    {
        $this->assertInstanceOf(
            Statement\Update::class,
            $this->subject->update()
        );
    }

    public function testDelete()
    {
        $this->assertInstanceOf(
            Statement\Delete::class,
            $this->subject->delete()
        );
    }
}
