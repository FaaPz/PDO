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
use FaaPz\PDO\Statement\Select;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class SelectTest extends TestCase
{
    /** @var Select $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new Select($this->createMock(Database::class));
    }

    public function testToString()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test');

        $this->assertEquals('SELECT id, name FROM test', $this->subject->__toString());
    }

    public function testToStringWithColumnAlias()
    {
        $this->subject
            ->columns(['id' => 'pk'])
            ->from('test');

        $this->assertStringEndsWith('pk AS id FROM test', $this->subject->__toString());
    }

    public function testToStringWithColumnSubQuery()
    {
        $this->subject
            ->columns(['sub' => (new Select($this->createMock(Database::class)))->from('test2')])
            ->from('test1');

        $this->assertStringEndsWith('(SELECT * FROM test2) AS sub FROM test1', $this->subject->__toString());
    }

    public function testToStringWithTableAlias()
    {
        $this->subject
            ->from(['alias' => 'test']);

        $this->assertStringEndsWith('FROM test AS alias', $this->subject->__toString());
    }

    public function testToStringWithTableSubQuery()
    {
        $this->subject
            ->from(['sub' => (new Select($this->createMock(Database::class)))->from('test')]);

        $this->assertEquals('SELECT * FROM (SELECT * FROM test) AS sub', $this->subject->__toString());
    }

    public function testToStringWithDistinct()
    {
        $this->subject
            ->distinct()
            ->from('test');

        $this->assertStringStartsWith('SELECT DISTINCT * FROM test', $this->subject->__toString());
    }

    public function testToStringWithColumns()
    {
        $this->subject
            ->from('test')
            ->columns(['col1', 'col2']);

        $this->assertStringStartsWith('SELECT col1, col2 FROM test', $this->subject->__toString());
    }

    public function testToStringWithoutColumns()
    {
        $this->subject
            ->from('test');

        $this->assertStringStartsWith('SELECT * FROM test', $this->subject->__toString());
    }

    public function testToStringEmptyColumns()
    {
        $this->subject
            ->from('test')
            ->columns([])
            ->columns();

        $this->assertStringStartsWith('SELECT * FROM test', $this->subject->__toString());
    }

    public function testToStringWithJoin()
    {
        $this->subject
            ->from('test1')
            ->join(new Join(
                'test2',
                new Conditional('test1.id', '=', 'test2.id')
            ));

        $this->assertStringEndsWith('FROM test1 JOIN test2 ON test1.id = ?', $this->subject->__toString());
    }

    public function testToStringWithWhere()
    {
        $this->subject
            ->from('test')
            ->where(new Conditional('id', '=', 1));

        $this->assertStringEndsWith('test WHERE id = ?', $this->subject->__toString());
    }

    public function testToStringWithGroupBy()
    {
        $this->subject
            ->from('test')
            ->groupBy('id', 'name');

        $this->assertStringEndsWith('test GROUP BY id, name', $this->subject->__toString());
    }

    public function testToStringWithUnion()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test1')
            ->union(
                (new Select($this->createMock(Database::class)))
                    ->columns(['id', 'name'])
                    ->from('test2')
            );

        $this->assertStringMatchesFormat(
            '(SELECT id, name FROM test1) UNION (SELECT id, name FROM test2)',
            $this->subject->__toString()
        );
    }

    public function testToStringWithUnionAll()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test1')
            ->unionAll(
                (new Select($this->createMock(Database::class)))
                    ->columns(['id', 'name'])
                    ->from('test2')
            );

        $this->assertStringMatchesFormat(
            '(SELECT id, name FROM test1) UNION ALL (SELECT id, name FROM test2)',
            $this->subject->__toString()
        );
    }

    public function testToStringWithHaving()
    {
        $this->subject
            ->from('test')
            ->having(new Conditional('id', '=', 1));

        $this->assertStringEndsWith('test HAVING id = ?', $this->subject->__toString());
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
            ->limit(new Limit(5, 25));

        $this->assertStringEndsWith('test LIMIT ? OFFSET ?', $this->subject->__toString());
    }

    public function testToStringWithoutTable()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/^No table set for select statement/');

        $this->subject->execute();
    }

    public function testToStringWithUnionMismatch()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test1')
            ->union(
                (new Select($this->createMock(Database::class)))
                    ->columns(['id', 'name'])
                    ->from('test2')
            )
            ->union(
                (new Select($this->createMock(Database::class)))
                    ->columns(['id', 'name'])
                    ->from('test2')
            );

        $property = new ReflectionProperty(Select::class, 'union');
        $property->setAccessible(true);
        $union = $property->getValue($this->subject);
        unset($union[0]);
        $property->setValue($this->subject, $union);

        $this->expectError();
        $this->expectErrorMessageMatches('/^Union offset mismatch/');

        $this->subject->__toString();
    }

    public function testGetValuesEmpty()
    {
        $this->assertIsArray($this->subject->getValues());
        $this->assertEmpty($this->subject->getValues());
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

    public function testGetValuesWithWhere()
    {
        $this->subject
            ->from('test')
            ->where(new Conditional('col', '<>', 5));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithUnion()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test1')
            ->where(new Conditional('id', '=', 1))
            ->union(
                (new Select($this->createMock(Database::class)))
                    ->columns(['id', 'name'])
                    ->from('test2')
                    ->where(new Conditional('id', '=', 2))
            );

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesWithUnionAll()
    {
        $this->subject
            ->columns(['id', 'name'])
            ->from('test1')
            ->where(new Conditional('id', '=', 1))
            ->unionAll(
                (new Select($this->createMock(Database::class)))
                    ->columns(['id', 'name'])
                    ->from('test2')
                    ->where(new Conditional('id', '=', 2))
            );

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesWithHaving()
    {
        $this->subject
            ->from('test')
            ->having(new Conditional('id', '=', 1));

        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithGroupBy()
    {
        $this->subject
            ->from('test')
            ->groupBy('id', 'name');

        $this->assertEmpty($this->subject->getValues());
    }

    public function testGetValuesWithLimit()
    {
        $this->subject
            ->from('test')
            ->limit(new Limit(25, 100));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }
}
