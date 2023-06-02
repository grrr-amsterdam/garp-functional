<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ModuloTest extends TestCase {

    public function test_should_modulo_numbers(): void {
        $this->assertEquals(0, f\modulo(5, 5));
        $this->assertEquals(1, f\modulo(2, 5));
        $this->assertEquals(1, f\modulo(3, 10));
    }

    public function test_should_be_curried(): void {
        $modulo5 = f\modulo(5);
        $this->assertTrue(is_callable($modulo5));
        $this->assertEquals(0, $modulo5(5));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\modulo));
    }
}
