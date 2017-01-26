<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class LtTest extends TestCase {

    public function test_should_check_if_n_is_greater() {
        $this->assertTrue(
            f\lt(20, 10)
        );
        $this->assertTrue(
            f\lt(0.52, 0.51)
        );
        $this->assertFalse(f\lt(50, 100));
    }

    public function test_should_be_curried() {
        $lessThan5 = f\lt(5);
        $this->assertTrue(is_callable($lessThan5));
        $this->assertTrue($lessThan5(3));
        $this->assertFalse($lessThan5(5.5));
    }

}

