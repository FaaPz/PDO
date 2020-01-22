<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use FaaPz\PDO\Statement;
use PDO;
use PHPUnit\Framework\TestCase;

class JoinTest extends TestCase
{
    public function testToString()
    {
        $subject = new Clause\Join(
            'table',
            new Clause\Conditional('column', '=', 'value')
        );

        $this->assertEquals('JOIN table ON column = ?', $subject->__toString());
    }

    public function testToStringWithType()
    {
        $subject = new Clause\Join(
            'table',
            new Clause\Conditional('column', '=', 'value'),
            'INNER'
        );

        $this->assertEquals('INNER JOIN table ON column = ?', $subject->__toString());
    }

    public function testToStringWithTableAlias()
    {
        $subject = new Clause\Join(
            ['alias' => 'table'],
            new Clause\Conditional('column1', '=', 'value1')
        );

        $this->assertEquals('JOIN table AS alias ON column1 = ?', $subject->__toString());
    }

    public function testToStringWithTableAliasException()
    {
        $subject = new Clause\Join(
            false,
            new Clause\Conditional('column1', '=', 'value1')
        );

        $this->expectError();
        $this->expectErrorMessageMatches('/^Invalid subject value/');

        $subject->__toString();
    }

    public function testToStringWithSelectTableAlias()
    {
        $subject = new Clause\Join(
            ['alias' => (new Statement\Select($this->createMock(PDO::class)))->from('table')],
            new Clause\Conditional('column1', '=', 'value1')
        );

        $this->assertStringMatchesFormat('JOIN (SELECT * FROM table) AS alias ON column1 = ?', $subject->__toString());
    }

    public function testToStringWithInvalidTableAlias()
    {
        $subject = new Clause\Join(
            ['alias', 'table'],
            new Clause\Conditional('column1', '=', 'value1')
        );

        $this->expectError();
        $this->expectErrorMessageMatches('/^Invalid subject array/');

        $subject->__toString();
    }

    public function testToStringWithGrouping()
    {
        $subject = new Clause\Join(
            'table',
            new Clause\Grouping(
                'AND',
                new Clause\Conditional('column1', '=', 'value1'),
                new Clause\Conditional('column2', '=', 'value2')
            )
        );

        $this->assertEquals('JOIN table ON column1 = ? AND column2 = ?', $subject->__toString());
    }

    public function testGetValues()
    {
        $subject = new Clause\Join(
            'table',
            new Clause\Conditional('column', '=', 'value')
        );

        $this->assertIsArray($subject->getValues());
        $this->assertCount(1, $subject->getValues());
    }
}
