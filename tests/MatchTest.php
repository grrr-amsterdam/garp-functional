<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockMusician;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MatchTest extends TestCase {

    public function test_should_match_strings(): void {
        $this->assertEquals(
            array('12345'),
            f\match_regex('/^\d+$/', '12345')
        );
        $this->assertFalse(
            f\match_regex('/^hello$/', 'goodbye')
        );
    }

    public function test_should_return_matches(): void {
        $this->assertEquals(
            array('Hello world', 'Hello'),
            f\match_regex('/([a-zA-Z]+) world/', 'Hello world')
        );
        $this->assertEquals(
            array('Goodbye world', 'Goodbye'),
            f\match_regex('/([a-zA-Z]+) world/', 'Goodbye world')
        );
    }

    public function test_should_not_throw_on_object_or_array(): void {
        $this->assertFalse(
            f\match_regex('/^(.*)$/', new stdClass())
        );
        $this->assertFalse(
            f\match_regex('/^(.*)$/', new InvalidArgumentException())
        );
        $this->assertFalse(
            f\match_regex('/^(.*)$/', array(1, 2, 3))
        );
    }

    public function test_should_match_objects_that_support_tostring(): void {
        $musician = new MockMusician('Miles', 'Davis');
        $this->assertTrue(
            !!f\match_regex('/Miles Davis/', $musician)
        );
        $this->assertFalse(
            f\match_regex('/John Coltrane/', $musician)
        );
    }

    public function test_should_be_curried(): void {
        $isNumeric = f\match_regex('/^\d+$/');
        $this->assertTrue(is_callable($isNumeric));
        $data = array(123, 'abc', array('90'), 456);
        $this->assertEquals(
            array(123, 456),
            f\filter($isNumeric, $data)
        );
    }

    public function test_usage_with_filter(): void {
        $isNumeric = f\match_regex('/^\d+$/');
        $this->assertTrue(is_callable($isNumeric));
        $this->assertEquals(
            array('123', '456'),
            f\filter($isNumeric, ['123', 'abc', '456'])
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\match_regex));
    }
}
