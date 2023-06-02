<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class AlwaysTest extends TestCase {

    public function test_should_return_a_constant_function(): void {
        $constMiles = f\always('Miles Davis');
        $this->assertEquals(
            'Miles Davis',
            $constMiles(1, 2, 3)
        );
        $this->assertEquals(
            'Miles Davis',
            $constMiles()
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\always));
    }
}
