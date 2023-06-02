<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MultiplyTest extends TestCase {

    public function test_should_multiply_numbers(): void {
        $this->assertEquals(25, f\multiply(5, 5));
        $this->assertEquals(10, f\multiply(5, 2));
        $this->assertEquals(30, f\multiply(10, 3));
    }

    public function test_should_be_curried(): void {
        $multiply5 = f\multiply(5);
        $this->assertTrue(is_callable($multiply5));
        $this->assertEquals(25, $multiply5(5));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\multiply));
    }
}
