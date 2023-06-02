<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class NoneTest extends TestCase {

    public function test_should_return_true_if_none_match(): void {
        $spices = array('clove', 'nutmeg', 'allspice', 'cumin');
        $this->assertTrue(f\none('is_int', $spices));
        $this->assertFalse(f\none('is_string', $spices));
    }

    public function test_should_return_false_for_one_match(): void {
        $data = array('clove', 123, 'abc', true, array(), false);
        $this->assertFalse(f\none('is_string', $data));
    }

    public function test_should_be_curried(): void {
        $noStrings = f\none('is_string');
        $this->assertTrue(is_callable($noStrings));
        $data = array('clove', 123, 'abc', true, array(), false);
        $this->assertFalse($noStrings($data));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\none));
    }
}
