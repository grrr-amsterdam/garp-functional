<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class FlipTest extends TestCase {

    public function test_should_flip_arguments() {
        $this->assertEquals(
            array('Miles', 'Davis'),
            call_user_func(f\flip('explode'), 'Miles Davis', ' ')
        );

        $reverseConcat = f\flip('Garp\Functional\concat');
        $this->assertEquals(
            'nanaba',
            $reverseConcat('ba', 'nana')
        );

        $subtract = function ($a, $b) {
            return $a - $b;
        };
        $this->assertEquals(
            3,
            $subtract(10, 7)
        );
        $this->assertEquals(
            -3,
            call_user_func(f\flip($subtract), 10, 7)
        );
    }

}

