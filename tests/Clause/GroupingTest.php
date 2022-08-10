<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Clause;

use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Grouping;
use PHPUnit\Framework\TestCase;

class GroupingTest extends TestCase
{
    public function testToString()
    {
        $subject = new Grouping(
            'AND',
            new Conditional('column1', '=', 'value1'),
            new Conditional('column2', '=', 'value2')
        );

        $this->assertEquals('column1 = ? AND column2 = ?', $subject->__toString());
    }

    public function testToStringNestedSelf()
    {
        $subject = new Grouping(
            'AND',
            new Conditional('column1', '=', 'value1'),
            new Grouping(
                'OR',
                new Conditional('column2', '=', 'value2'),
                new Conditional('column3', '=', 'value3')
            )
        );

        $this->assertEquals('column1 = ? AND (column2 = ? OR column3 = ?)', $subject->__toString());
    }

    public function testGetValues()
    {
        $subject = new Grouping(
            'AND',
            new Conditional('column1', '=', 'value1'),
            new Conditional('column2', '=', 'value2')
        );

        $this->assertIsArray($subject->getValues());
        $this->assertCount(2, $subject->getValues());
    }
}
