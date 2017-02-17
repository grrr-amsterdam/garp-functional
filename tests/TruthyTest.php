<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TruthyTest extends TestCase {

    public function test_truthy() {
        $this->assertTrue(f\truthy('1234'));
        $this->assertTrue(f\truthy(true));
        $this->assertFalse(f\truthy('0'));
        $this->assertFalse(f\truthy(''));
        $this->assertTrue(f\truthy(array(1, 2, 3)));
    }

    public function test_truthy_should_accept_functions() {
        $isArray = f\truthy('is_array');
        $this->assertTrue(is_callable($isArray));
        $this->assertTrue($isArray(array()));
        $this->assertFalse($isArray(123));
    }
}
