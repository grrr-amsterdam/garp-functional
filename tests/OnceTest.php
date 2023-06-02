<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class OnceTest extends TestCase {

    protected $_counter = 0;

    public function test_should_execute_but_once(): void {
        $onceFn = f\once('strtoupper');
        $this->assertTrue(is_callable($onceFn));

        $incrementOnce = f\once(array($this, 'incrementCounter'));
        $incrementOnce();
        $this->assertSame(1, $this->_counter);

        $incrementOnce();
        $this->assertSame(1, $this->_counter);
    }

    public function test_it_passes_arguments_correctly(): void {
        $addOnce = f\once(array($this, 'addToCounter'));
        $addOnce(2);
        $this->assertSame(2, $this->_counter);

        $addOnce(5);
        $this->assertSame(2, $this->_counter);
    }

    public function test_it_returns_the_return_value_of_the_first_call(): void {
        $addOne = function ($x) {
            return $x + 1;
        };
        $addOneOnce = f\once($addOne);
        $this->assertSame(11, $addOneOnce(10));
        $this->assertSame(11, $addOneOnce(50));
    }

    public function incrementCounter(): void {
        $this->_counter += 1;
    }

    public function addToCounter($num): void {
        $this->_counter += $num;
    }

    public function setUp(): void {
        $this->_counter = 0;
    }
    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\once));
    }
}
