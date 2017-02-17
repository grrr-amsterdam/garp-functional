<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class BothTest extends TestCase {

    public function test_both() {
        $this->assertTrue(
            f\both(12345, '12345')
        );
        $this->assertTrue(
            f\both(array(1), true)
        );
        $this->assertFalse(
            f\both(array(), '123')
        );
        $this->assertFalse(
            f\both(0, false)
        );
        $this->assertFalse(
            f\both('cheese', false)
        );
    }

    public function test_both_should_accept_functions() {
        $isMediumNumber = f\both(f\gt(50), f\lt(200));
        $this->assertTrue(is_callable($isMediumNumber));
        $this->assertTrue(
            $isMediumNumber(67)
        );
        $this->assertTrue(
            $isMediumNumber(199)
        );
        $this->assertFalse(
            $isMediumNumber(10)
        );
        $this->assertFalse(
            $isMediumNumber(600)
        );
    }

}
