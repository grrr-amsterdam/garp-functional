<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\CallableObject;
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
        $this->assertFalse(f\truthy(array()));
    }

    public function test_truthy_should_accept_functions() {
        $isArray = f\truthy('is_array');
        $this->assertTrue(is_callable($isArray));
        $this->assertTrue($isArray(array()));
        $this->assertFalse($isArray(123));
    }

    public function test_should_work_with_callable_objects() {
        $obj = new CallableObject(24);
        $this->assertTrue(f\truthy($obj));
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\truthy));
    }
}
