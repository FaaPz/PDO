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

class UpdateTest extends TestCase
{
    /** @var Statement\Update $subject */
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

        $pdo = $this->createMock(PDO::class);
        $pdo->method('prepare')
            ->with($this->anything())
            ->willReturn($stmt);

        $this->subject = new Statement\Update($pdo);
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
            ->pairs(['col' => 'value']);

        $this->assertStringStartsWith('UPDATE test SET col = ?', $this->subject->__toString());
    }

    public function testToStringWithWhere()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->where(new Clause\Conditional('id', '=', 1));

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

    public function testToStringWithLimit()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value')
            ->limit(new Clause\Limit(
                25,
                100
            ));

        $this->assertStringEndsWith(' LIMIT ?, ?', $this->subject->__toString());
    }

    public function testToStringWithoutTable()
    {
        $this->expectException(DatabaseException::class);

        $this->subject->execute();
    }

    public function testToStringWithoutPairs()
    {
        $this->expectException(DatabaseException::class);

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
            ->pairs(['col' => 'value']);

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(1, $this->subject->getValues());
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
            ->limit(new Clause\Limit(
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

    public function testExecute()
    {
        $this->subject
            ->table('test')
            ->set('col', 'value');

        $this->assertEquals(1, $this->subject->execute());
    }
}
