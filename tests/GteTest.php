<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class GteTest extends TestCase {

    public function test_should_check_if_n_is_greater() {
        $this->assertTrue(
            f\gte(10, 20)
        );
        $this->assertTrue(
            f\gte(0.5, 0.51)
        );
        $this->assertTrue(
            f\gte(100, 100)
        );
        $this->assertFalse(f\gte(100, 50));
    }

    public function test_should_be_curried() {
        $moreThan5 = f\gte(5);
        $this->assertTrue(is_callable($moreThan5));
        $this->assertTrue($moreThan5(10));
    }

}
