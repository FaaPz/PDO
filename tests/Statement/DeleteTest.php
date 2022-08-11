<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Statement;

use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Join;
use FaaPz\PDO\Clause\Limit;
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Delete;
use FaaPz\PDO\Statement\DeleteInterface;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    /** @var Database */
    private $db;

    /** @var DeleteInterface $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')
            ->with($this->anything())
            ->willReturn($stmt);
        $stmt->method('rowCount')
            ->willReturn(1);

        $this->db = $this->createMock(Database::class);
        $this->db->method('prepare')
            ->with($this->anything())
            ->willReturn($stmt);

        $this->subject = new Delete($this->db);
    }

    public function testToString()
    {
        $this->subject->from('test');

        $this->assertStringStartsWith('DELETE FROM test', $this->subject->__toString());
    }

    public function testToStringWithAlias()
    {
        $this->subject
            ->from(['alias' => 'test']);

        $this->assertStringEndsWith('test AS alias', $this->subject->__toString());
    }

    public function testToStringWithConstructorTable()
    {
        $this->subject = new Delete($this->db, ['alias' => 'test']);

        $this->assertStringEndsWith('test AS alias', $this->subject->__toString());
    }

    public function testToStringWithoutTable()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/^No table set for delete statement/');

        $this->subject->__toString();
    }

    public function testToStringWithJoin()
    {
        $this->subject
            ->from('test1')
            ->join(new Join(
                'test2',
                new Conditional('test1.id', '=', 'test2.id')
            ));

        $this->assertStringEndsWith('test1 JOIN test2 ON test1.id = ?', $this->subject->__toString());
    }

    public function testToStringWithWhere()
    {
        $this->subject
            ->from('test')
            ->where(new Conditional('id', '=', 1));

        $this->assertStringEndsWith('WHERE id = ?', $this->subject->__toString());
    }

    public function testToStringWithOrderBy()
    {
        $this->subject
            ->from('test')
            ->orderBy('id', 'ASC')
            ->orderBy('name', 'DESC');

        $this->assertStringEndsWith(' ORDER BY id ASC, name DESC', $this->subject->__toString());
    }

    public function testToStringWithOrderByWithoutDirection()
    {
        $this->subject
            ->from('test')
            ->orderBy('id')
            ->orderBy('name');

        $this->assertStringEndsWith(' ORDER BY id, name', $this->subject->__toString());
    }

    public function testToStringWithLimit()
    {
        $this->subject
            ->from('test')
            ->limit(new Limit(
                25,
                100
            ));

        $this->assertStringEndsWith('test LIMIT ? OFFSET ?', $this->subject->__toString());
    }

    public function testGetValues()
    {
        $this->assertIsArray($this->subject->getValues());
        $this->assertEmpty($this->subject->getValues());
    }

    public function testGetValuesWithWhere()
    {
        $this->subject
            ->from('test')
            ->where(new Conditional('id', '=', 1));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithJoin()
    {
        $this->subject
            ->from('test1')
            ->join(new Join(
                'test2',
                new Conditional('test1.id', '=', 'test2.id')
            ));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithOrderBy()
    {
        $this->subject
            ->from('test1')
            ->orderBy('id', 'ASC')
            ->orderBy('name', 'DESC');

        // FIXME This seems broken...
        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesWithLimit()
    {
        $this->subject
            ->from('test1')
            ->limit(new Limit(
                25,
                100
            ));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }
}
