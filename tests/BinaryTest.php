<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockMusician;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class BinaryTest extends TestCase {

    public function test_should_make_function_binary(): void {
        /**
         * The native method_exists throws an error when given more than 2 arguments.
         */
        $mockMusician = new MockMusician('Miles', 'Davis');
        $binaryMethodExists = f\binary('method_exists');
        $this->assertTrue(
            $binaryMethodExists($mockMusician, '__toString', 'foobar')
        );

        /**
         * A simpler example to prove it works:
         */
        $countArgs = function () {
            return func_num_args();
        };
        $this->assertEquals(3, $countArgs('a', 'b', 'c'));

        $countArgsUnary = f\binary($countArgs);
        $this->assertEquals(2, $countArgsUnary('a', 'b', 'c'));
    }

}

