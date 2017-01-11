<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class UnaryTest extends TestCase {

    public function test_should_make_function_unary() {
        /**
         * Explanation with this example: is_array blows up when given more than one argument.
         * some(), however, passes the index as well as the item to the callback function.
         * We can use unary() to make sure but a single argument will be given
         * to is_array.
         */
        $hasArray = f\some(f\unary('is_array'));
        $stuff = array('abc', array(), 123, true);
        $this->assertTrue($hasArray($stuff));

        /**
         * A simpler example to prove it works:
         */
        $countArgs = function () {
            return func_num_args();
        };
        $this->assertEquals(3, $countArgs('a', 'b', 'c'));

        $countArgsUnary = f\unary($countArgs);
        $this->assertEquals(1, $countArgsUnary('a', 'b', 'c'));
    }

}

