<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class DivideTest extends TestCase {

    public function test_should_divide_numbers() {
        $this->assertEquals(1, f\divide(5, 5));
        $this->assertEquals(5, f\divide(2, 10));
        $this->assertEquals(4, f\divide(5, 20));
    }

    public function test_should_be_curried() {
        $divide5 = f\divide(5);
        $this->assertTrue(is_callable($divide5));
        $this->assertEquals(1, $divide5(5));
    }

}
