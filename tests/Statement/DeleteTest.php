<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use FaaPz\PDO\Statement;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    /** @var PDO */
    private $pdo;

    /** @var Statement\Delete $subject */
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

        $this->pdo = $this->createMock(PDO::class);
        $this->pdo->method('prepare')
            ->with($this->anything())
            ->willReturn($stmt);

        $this->subject = new Statement\Delete($this->pdo);
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
        $this->subject = new Statement\Delete($this->pdo, ['alias' => 'test']);

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
            ->join(new Clause\Join(
                'test2',
                new Clause\Conditional('test1.id', '=', 'test2.id')
            ));

        $this->assertStringEndsWith('test1 JOIN test2 ON test1.id = ?', $this->subject->__toString());
    }

    public function testToStringWithWhere()
    {
        $this->subject
            ->from('test')
            ->where(new Clause\Conditional('id', '=', 1));

        $this->assertStringEndsWith('WHERE id = ?', $this->subject->__toString());
    }

    public function testToStringWithOrderBy()
    {
        $this->subject
            ->from('test')
            ->orderBy('id', 'ASC')
            ->orderBy('name', 'DESC');

        // FIXME This seems broken...
        $this->assertStringEndsWith('test ORDER BY id ASC, name DESC', $this->subject->__toString());
    }

    public function testToStringWithLimit()
    {
        $this->subject
            ->from('test')
            ->limit(new Clause\Limit(
                25,
                100
            ));

        $this->assertStringEndsWith('test LIMIT ?, ?', $this->subject->__toString());
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
            ->where(new Clause\Conditional('id', '=', 1));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithJoin()
    {
        $this->subject
            ->from('test1')
            ->join(new Clause\Join(
                'test2',
                new Clause\Conditional('test1.id', '=', 'test2.id')
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
            ->limit(new Clause\Limit(
                25,
                100
            ));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }
}
