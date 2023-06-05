<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SplitTest extends TestCase {

    public function test_should_split_strings(): void {
        $this->assertEquals(
            array('Miles', 'Davis'),
            f\split(' ', 'Miles Davis')
        );
        $this->assertEquals(
            array('Foo bar'),
            f\split('x', 'Foo bar')
        );
    }

    public function test_should_be_curried(): void {
        $splitOnSpace = f\split(' ');
        $this->assertTrue(is_callable($splitOnSpace));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\split));
    }
}
