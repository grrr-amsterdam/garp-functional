<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TapTest extends TestCase {

    public function test_should_tap() {
        $stuff = array();
        $addToStuff = function () use (&$stuff) {
            $stuff[] = uniqid();
        };
        $tappedAddToStuff = f\tap($addToStuff);
        $this->assertEquals('abc', $tappedAddToStuff('abc'));
        $this->assertCount(1, $stuff);
        $this->assertEquals(123, $tappedAddToStuff(123));
        $this->assertCount(2, $stuff);
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\tap));
    }
}
