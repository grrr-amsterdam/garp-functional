<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class IsCallableFunctionTest extends TestCase {

    public function test_should_recognize_callable_functions() {
        $mockMusician = new MockMusician('Miles', 'Davis');
        $multiply = function ($n) {
            return $n * $n;
        };
        $closure = \Closure::bind($multiply, $mockMusician);

        $this->assertTrue(
            f\is_callable_function('strtolower'),
            'It recognizes native PHP functions'
        );
        $this->assertTrue(
            f\is_callable_function($multiply),
            'It recognizes a closure'
        );
        $this->assertTrue(
            f\is_callable_function(array($mockMusician, 'getName')),
            'It recognizes array-style for object methods'
        );
        $this->assertTrue(
            f\is_callable_function(array('MockSpiceTraverser', 'instance')),
            'It recognizes array-style for static methods'
        );
        $this->assertTrue(
            f\is_callable_function('MockSpiceTraverser::instance'),
            'It recognizes string-style for static methods'
        );
        $this->assertTrue(
            f\is_callable_function($closure),
            'It recognizes Closure instances'
        );
        $this->assertFalse(
            f\is_callable_function(new CallableObject(24)),
            'It rejects objects with __invoke'
        );
    }

}
