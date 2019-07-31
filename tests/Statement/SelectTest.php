<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaapZ\PDO\Clause;
use FaaPz\PDO\DatabaseException;
use FaaPz\PDO\Statement;
use PDO;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    /** @var Statement\Select $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new Statement\Select($this->createMock(PDO::class));
    }

    public function testToString()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test');

        $this->assertEquals('SELECT id, name FROM test', $this->subject->__toString());
    }

    public function testToStringWithAlias()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from(['alias' => 'test']);

        $this->assertStringEndsWith('test AS alias', $this->subject->__toString());
    }

    public function testToStringWithDistinct()
    {
        $this->subject
            ->distinct()
            ->from('test');

        $this->assertStringStartsWith('SELECT DISTINCT * FROM test', $this->subject->__toString());
    }

    public function testToStringWithJoin()
    {
        $this->subject
            ->from('test1')
            ->join(new Clause\Join(
                'test2',
                new Clause\Conditional('test1.id', '=', 'test2.id')
            ));

        $this->assertStringEndsWith('FROM test1 JOIN test2 ON test1.id = ?', $this->subject->__toString());
    }

    public function testToStringWithWhere()
    {
        $this->subject
            ->from('test')
            ->where(new Clause\Conditional('id', '=', 1));

        $this->assertStringEndsWith('test WHERE id = ?', $this->subject->__toString());
    }

    public function testToStringWithGroupBy()
    {
        $this->subject
            ->from('test')
            ->groupBy('id', 'name');

        $this->assertStringEndsWith('test GROUP BY id, name', $this->subject->__toString());
    }

    public function testToStringWithHaving()
    {
        $this->subject
            ->from('test')
            ->having(new Clause\Conditional('id', '=', 1));

        $this->assertStringEndsWith('test HAVING id = ?', $this->subject->__toString());
    }

    public function testToStringWithOrderBy()
    {
        $this->subject
            ->from('test')
            ->orderBy('id', 'ASC')
            ->orderBy('name', 'DESC');

        $this->assertStringEndsWith('test ORDER BY id ASC, name DESC', $this->subject->__toString());
    }

    public function testToStringWithLimit()
    {
        $this->subject
            ->from('test')
            ->limit(new Clause\Limit(5, 25));

        $this->assertStringEndsWith('test LIMIT ?, ?', $this->subject->__toString());
    }

    public function testToStringWithoutTable()
    {
        $this->expectException(DatabaseException::class);

        $this->subject->execute();
    }

    public function testToStringWithoutColumns()
    {
        $this->subject
            ->from('test');

        $this->assertStringStartsWith('SELECT * FROM test', $this->subject->__toString());
    }

    public function testGetValuesEmpty()
    {
        $this->assertIsArray($this->subject->getValues());
        $this->assertEmpty($this->subject->getValues());
    }

    public function testGetValuesWithUnion()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test1')
            ->union(
                (new Statement\Select($this->createMock(PDO::class)))
                    ->columns(['id', 'name'])
                    ->from('test2')
            );

        $this->assertStringMatchesFormat('(SELECT id, name FROM test1) UNION (SELECT id, name FROM test2)', $this->subject->__toString());
    }

    public function testGetValuesWithGroupBy()
    {
        $this->subject
            ->from('test')
            ->groupBy('id', 'name');

        $this->assertEmpty($this->subject->getValues());
    }

    public function testGetValuesWithHaving()
    {
        $this->subject
            ->from('test')
            ->having(new Clause\Conditional('id', '=', 1));

        $this->assertCount(1, $this->subject->getValues());
    }
}
