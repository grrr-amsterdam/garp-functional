<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class EveryTest extends TestCase {

    public function test_should_return_true_if_all_match(): void {
        $spices = array('clove', 'nutmeg', 'allspice', 'cumin');
        $this->assertTrue(f\every('is_string', $spices));
    }

    public function test_should_return_false_for_one_mismatch(): void {
        $data = array('clove', 123, 'abc', true, array(), false);
        $this->assertFalse(f\every('is_string', $data));
    }

    public function test_should_be_curried(): void {
        $data = array('clove', 123, 'abc', true, array(), false);
        $naughtButStrings = f\every('is_string');
        $this->assertTrue(is_callable($naughtButStrings));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\every));
    }
}
