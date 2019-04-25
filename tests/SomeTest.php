<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SomeTest extends TestCase {

    public function test_should_give_true_if_callback_returns_true_at_least_once() {
        $spices = array('nutmeg', 'cinnamon', 'clove');
        $lengthAtLeastSeven = function ($str) {
            return strlen($str) >= 7;
        };
        $this->assertTrue(f\some($lengthAtLeastSeven, $spices));
        $lengthAtLeastNine = function ($str) {
            return strlen($str) >= 9;
        };
        $this->assertFalse(f\some($lengthAtLeastNine, $spices));
    }

    public function test_should_be_curried() {
        $hasNumbers = f\some(f\unary('is_numeric'));
        $stuff = array('abc', array(), 123, true);
        $this->assertTrue($hasNumbers($stuff));
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\some));
    }
}
