<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SubtractTest extends TestCase {

    public function test_should_substract_numbers() {
        $this->assertEquals(0, f\substract(5, 5));
        $this->assertEquals(-5, f\substract(5, 0));
        $this->assertEquals(10, f\substract(40, 50));
    }

    public function test_should_be_curried() {
        $substract5 = f\substract(5);
        $this->assertTrue(is_callable($substract5));
        $this->assertEquals(0, $substract5(5));
        $this->assertEquals(5, $substract5(10));
    }

}
