<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class LastTest extends TestCase {

    public function test_should_get_last_item_in_array(): void {
        $this->assertEquals(
            'baz',
            f\last(array('foo', 'bar', 'baz'))
        );
        $this->assertEquals(
            'Miles',
            f\last(array('Herbie', 'John', 'Miles'))
        );
        $this->assertNull(f\last(array()));
    }

    public function test_should_get_last_item_in_assoc_array(): void {
        $this->assertEquals(
            'baz',
            f\last(array('a' => 'foo', 'b' => 'bar', 'c' => 'baz'))
        );
    }

    public function test_should_get_last_char_in_strings(): void {
        $this->assertEquals(
            'S',
            f\last('MILES')
        );
        $this->assertEquals(
            '',
            f\last('')
        );
    }

    public function test_should_get_last_item_in_iterable(): void {
        $spiceTraverser = new MockSpiceTraverser();
        $this->assertEquals(
            'clove',
            f\last($spiceTraverser)
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\last));
    }
}
