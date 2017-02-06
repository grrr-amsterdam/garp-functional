<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MatchTest extends TestCase {

    public function test_should_match_strings() {
        $this->assertTrue(
            f\match('/^\d+$/', '12345')
        );
        $this->assertFalse(
            f\match('/^hello$/', 'goodbye')
        );
    }

    public function test_should_not_throw_on_object_or_array() {
        $this->assertFalse(
            f\match('/^(.*)$/', new stdClass())
        );
        $this->assertFalse(
            f\match('/^(.*)$/', new InvalidArgumentException())
        );
        $this->assertFalse(
            f\match('/^(.*)$/', array(1, 2, 3))
        );
    }

    public function test_should_match_objects_that_support_tostring() {
        $musician = new MockMusician('Miles', 'Davis');
        $this->assertTrue(
            f\match('/Miles Davis/', $musician)
        );
        $this->assertFalse(
            f\match('/John Coltrane/', $musician)
        );
    }

    public function test_should_be_curried() {
        $isNumeric = f\match('/^\d+$/');
        $this->assertTrue(is_callable($isNumeric));
        $data = array(123, 'abc', array('90'), 456);
        $this->assertEquals(
            array(123, 456),
            f\reindex(f\filter($isNumeric, $data))
        );
    }

}
