<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use FaaPz\PDO\DatabaseException;
use FaaPz\PDO\Statement;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    /** @var Statement\Insert $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')
            ->with($this->anything())
            ->willReturn($stmt);

        $pdo = $this->createMock(PDO::class);
        $pdo->method('prepare')
            ->with($this->anything())
            ->willReturn($stmt);
        $pdo->method('lastInsertId')
            ->willReturn(1);

        $this->subject = new Statement\Insert($pdo);
    }

    public function testToString()
    {
        $this->subject
            ->into('test')
            ->columns('one', 'two')
            ->values(1, 2);

        $this->assertStringStartsWith('INSERT INTO test', $this->subject->__toString());
    }

    public function testToStringWithoutTable()
    {
        $this->expectException(DatabaseException::class);

        $this->subject
            ->columns('one', 'two')
            ->values(1, 2)
            ->execute();
    }

    public function testToStringWithoutColumns()
    {
        $this->expectException(DatabaseException::class);

        $this->subject
            ->into('test')
            ->values(1, 2)
            ->execute();
    }

    public function testToStringWithoutValues()
    {
        $this->expectException(DatabaseException::class);

        $this->subject
            ->into('test')
            ->columns('one', 'two')
            ->execute();
    }

    public function testToStringWithIgnore()
    {
        $this->subject
            ->ignore()
            ->into('test')
            ->columns('one', 'two')
            ->values(1, 2)
            ->execute();

        $this->assertStringStartsWith('INSERT IGNORE INTO test', $this->subject->__toString());
    }

    public function testToStringWithQuery()
    {
        $this->subject
            ->into('test')
            ->columns('one')
            ->values(new Clause\Raw('1'));

        $this->assertStringStartsWith('INSERT INTO test (one) VALUES (1)', $this->subject->__toString());
    }

    public function testGetValues()
    {
        $this->subject
            ->into('test')
            ->columns('one', 'two')
            ->values(1, 2);

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesEmpty()
    {
        $this->assertIsArray($this->subject->getValues());
        $this->assertEmpty($this->subject->getValues());
    }

    public function testGetValuesWithWhere()
    {
        $this->subject
            ->columns('one', 'two')
            ->values(1, 2);

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesWithQuery()
    {
        $this->subject
            ->columns('one')
            ->values(new Clause\Raw('1'));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(0, $this->subject->getValues());
    }

    public function testExecute()
    {
        $this->subject
            ->into('test')
            ->columns('id')
            ->values(1);

        $this->assertEquals(1, $this->subject->execute());
    }
}