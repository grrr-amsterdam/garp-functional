<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SubtractTest extends TestCase {

    public function test_should_subtract_numbers() {
        $this->assertEquals(0, f\subtract(5, 5));
        $this->assertEquals(-5, f\subtract(5, 0));
        $this->assertEquals(10, f\subtract(40, 50));
    }

    public function test_should_be_curried() {
        $subtract5 = f\subtract(5);
        $this->assertTrue(is_callable($subtract5));
        $this->assertEquals(0, $subtract5(5));
        $this->assertEquals(5, $subtract5(10));
    }

}
