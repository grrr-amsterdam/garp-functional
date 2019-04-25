<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class AddTest extends TestCase {

    public function test_should_add_numbers() {
        $this->assertEquals(10, f\add(5, 5));
        $this->assertEquals(5, f\add(5, 0));
        $this->assertEquals(5, f\add(10, -5));
    }

    public function test_should_be_curried() {
        $add5 = f\add(5);
        $this->assertTrue(is_callable($add5));
        $this->assertEquals(10, $add5(5));
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\add));
    }
}
