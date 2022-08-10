<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Statement;

use FaaPz\PDO\Clause\Raw;
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Insert;
use FaaPz\PDO\Statement\Select;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    /** @var Insert $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')
            ->with($this->anything())
            ->willReturn($stmt);

        $pdo = $this->createMock(Database::class);
        $pdo->method('prepare')
            ->with($this->anything())
            ->willReturn($stmt);
        $pdo->method('lastInsertId')
            ->willReturn(1);

        $this->subject = new Insert($pdo);
    }

    public function testToString()
    {
        $this->subject
            ->into('test')
            ->columns('one', 'two')
            ->values(1, 2);

        $this->assertEquals('INSERT INTO test (one, two) VALUES (?, ?)', $this->subject->__toString());
    }

    public function testToStringWithoutTable()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/insert statement$/');

        $this->subject
            ->columns('one', 'two')
            ->values(1, 2)
            ->execute();
    }

    public function testToStringWithColumns()
    {
        $this->subject
            ->into('test')
            ->columns('col1', 'col2')
            ->values(1, 2);

        $this->assertEquals('INSERT INTO test (col1, col2) VALUES (?, ?)', $this->subject->__toString());
    }

    public function testToStringWithColumnMismatch()
    {
        $this->subject
            ->into('test')
            ->columns('col2')
            ->values(1, 2);

        $this->expectError();
        $this->expectErrorMessageMatches('/^Column value count mismatch for insert statement/');

        $this->subject->__toString();
    }

    public function testToStringWithoutColumns()
    {
        $this->subject
            ->into('test')
            ->values(1, 2);

        $this->assertEquals('INSERT INTO test VALUES (?, ?)', $this->subject->__toString());
    }

    public function testToStringWithoutValues()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/insert statement$/');

        $this->subject
            ->into('test')
            ->columns('one', 'two')
            ->execute();
    }

    public function testToStringWithSelect()
    {
        $select = new Select($this->createMock(Database::class));
        $select->from('table');

        $this->subject
            ->into('test')
            ->values($select)
            ->execute();

        $this->assertEquals('INSERT INTO test SELECT * FROM table', $this->subject->__toString());
    }

    public function testToStringWithSelectAndArgs()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/^Ignoring additional values after select for insert statement/');

        $select = new Select($this->createMock(Database::class));
        $select->from('table');

        $this->subject
            ->into('test')
            ->values($select, 2)
            ->execute();
    }

    public function testToStringWithLowPriority()
    {
        $this->subject
            ->priority('low_priority')
            ->into('test')
            ->columns('one', 'two')
            ->values(1, 2)
            ->execute();

        $this->assertStringStartsWith('INSERT LOW_PRIORITY INTO test', $this->subject->__toString());
    }

    public function testToStringWithHighPriority()
    {
        $this->subject
            ->priority('high')
            ->into('test')
            ->columns('one', 'two')
            ->values(1, 2)
            ->execute();

        $this->assertStringStartsWith('INSERT HIGH_PRIORITY INTO test', $this->subject->__toString());
    }

    public function testToStringWithInvalidPriority()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/^Invalid priority type/');

        $this->subject
            ->priority('invalid')
            ->into('test')
            ->columns('one', 'two')
            ->values(1, 2)
            ->execute();

        $this->subject->__toString();
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

    public function testToStringWithRaw()
    {
        $this->subject
            ->into('test')
            ->columns('one')
            ->values(new Raw('1'));

        $this->assertStringStartsWith('INSERT INTO test (one) VALUES (1)', $this->subject->__toString());
    }

    public function testToStringWithOnDuplicateUpdate()
    {
        $this->subject
            ->into('test')
            ->columns('one')
            ->values(1)
            ->onDuplicateUpdate(['one' => 2]);

        $this->assertStringStartsWith(
            'INSERT INTO test (one) VALUES (?) ON DUPLICATE KEY UPDATE one = ?',
            $this->subject->__toString()
        );
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
            ->values(new Raw('1'));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(0, $this->subject->getValues());
    }

    public function testGetValuesWithOnDuplicateUpdate()
    {
        $this->subject
            ->columns('one')
            ->values(1)
            ->onDuplicateUpdate([
                'one' => 2,
                'two' => new Raw('1'),
            ]);

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }
}
