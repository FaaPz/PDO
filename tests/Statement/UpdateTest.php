<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Statement;

use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Join;
use FaaPz\PDO\Clause\Limit;
use FaaPz\PDO\Clause\Raw;
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;
use FaaPz\PDO\Statement\Update;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class UpdateTest extends TestCase
{
    /** @var Update $subject */
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

        $pdo = $this->createMock(Database::class);
        $pdo->method('prepare')
            ->with($this->anything())
            ->willReturn($stmt);

        $this->subject = new Update($pdo);
    }

    public function testToString()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value');

        $this->assertStringStartsWith('UPDATE test SET col = ?', $this->subject->__toString());
    }

    public function testToStringWithPairs()
    {
        $this->subject
            ->table('test')
            ->pairs([
                'col1' => 'value1',
                'col2' => 'value2',
            ]);

        $this->assertStringStartsWith('UPDATE test SET col1 = ?, col2 = ?', $this->subject->__toString());
    }

    public function testToStringWithRaw()
    {
        $this->subject
            ->table('test')
            ->set('col', new Raw('col + 1'));

        $this->assertStringStartsWith('UPDATE test SET col = col + 1', $this->subject->__toString());
    }

    public function testToStringWithSelect()
    {
        $select = new Select($this->createMock(Database::class), ['col2']);
        $select->from('table');

        $this->subject
            ->table('test')
            ->set('col1', $select);

        $this->assertStringStartsWith('UPDATE test SET col1 = (SELECT col2 FROM table)', $this->subject->__toString());
    }

    public function testToStringWithJoin()
    {
        $this->subject
            ->table('test1')
            ->set('col', 'value')
            ->join(new Join(
                'test2',
                new Conditional('test1.id', '=', 'test2.id')
            ));

        $this->assertStringStartsWith('UPDATE test1 JOIN test2 ON test1.id = ?', $this->subject->__toString());
    }

    public function testToStringWithWhere()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->where(new Conditional('id', '=', 1));

        $this->assertStringEndsWith('? WHERE id = ?', $this->subject->__toString());
    }

    public function testToStringWithOrderBy()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->orderBy('id', 'ASC')
            ->orderBy('name', 'DESC');

        $this->assertStringEndsWith(' ORDER BY id ASC, name DESC', $this->subject->__toString());
    }

    public function testToStringWithOrderByWithoutDirection()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->orderBy('id')
            ->orderBy('name');

        $this->assertStringEndsWith(' ORDER BY id, name', $this->subject->__toString());
    }

    public function testToStringWithLimit()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->limit(new Limit(
                25,
                100
            ));

        $this->assertStringEndsWith(' LIMIT ? OFFSET ?', $this->subject->__toString());
    }

    public function testToStringWithUnion()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->limit(new Limit(
                25,
                100
            ));

        $this->assertStringEndsWith(' LIMIT ? OFFSET ?', $this->subject->__toString());
    }

    public function testToStringWithoutTable()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/^No table set for update statement/');

        $this->subject->execute();
    }

    public function testToStringWithoutPairs()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/^No column \/ value pairs set for update statement/');

        $this->subject
            ->table('test')
            ->execute();
    }

    public function testGetValues()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value');

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithPairs()
    {
        $this->subject
            ->table('test')
            ->pairs([
                'col1' => 'value1',
                'col2' => 'value2',
            ]);

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesWithSelect()
    {
        $select = new Select($this->createMock(Database::class), ['col2']);
        $select->from('table')
               ->where(new Conditional('col2', '=', 2));

        $this->subject
            ->table('test')
            ->set('col1', $select);

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithJoin()
    {
        $this->subject
            ->table('test1')
            ->set('col', 'value')
            ->join(new Join(
                'test2',
                new Conditional('test1.id', '=', 1)
            ));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesWithWhere()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->where(new Conditional('col', '<>', 5));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }

    public function testGetValuesWithOrderBy()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->orderBy('id', 'ASC')
            ->orderBy('name', 'DESC');

        // FIXME This seems broken...
        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
    }

    public function testGetValuesWithLimit()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->limit(new Limit(
                25,
                100
            ));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(3, $this->subject->getValues());
    }

    public function testGetValuesEmpty()
    {
        $this->assertIsArray($this->subject->getValues());
        $this->assertEmpty($this->subject->getValues());
    }
}
