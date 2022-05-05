<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause\Parenthesis;
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Clause\Raw;
use PHPUnit\Framework\TestCase;

class ParenthesisTest extends TestCase
{
    public function testToString()
    {
        $subject = new Parenthesis('col', '=', 'val');

        $this->assertEquals('(col = ?)', $subject->__toString());
    }

    public function testToStringWithAndConditional()
    {
        $subject = new Parenthesis(new Conditional('col', '=', 'val'), 'AND', new Conditional('col', '!=', 'val'));

        $this->assertEquals('(col = ? AND col != ?)', $subject->__toString());
    }

    public function testToStringWithAndOrConditional()
    {
        $subject1 = new Parenthesis(new Conditional('col', '=', 'val'), 'AND', new Conditional('col', '!=', 'val'));
        $subject2 = new Parenthesis(new Conditional('col', '=', 'val'), 'AND', new Conditional('col', '!=', 'val'));
        $subject  = new Conditional($subject1, 'OR', $subject2);

        $this->assertEquals('(col = ? AND col != ?) OR (col = ? AND col != ?)', $subject->__toString());
    }

}
