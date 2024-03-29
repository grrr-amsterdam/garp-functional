<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use Garp\Functional\Tests\Helpers\MockMusician;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class CountTest extends TestCase {

    public function test_should_count_arrays(): void {
        $this->assertEquals(
            3,
            f\count(array('a', 'b', 'c'))
        );
        $this->assertEquals(
            0,
            f\count(array())
        );
        $this->assertEquals(
            3,
            f\count(
                array(
                    'foo' => 'bar',
                    'baz' => 'quz',
                    'qux' => 'vox'
                )
            )
        );
    }

    public function test_should_count_traversables(): void {
        $this->assertEquals(
            3, f\count(new MockSpiceTraverser())
        );
    }

    public function test_should_count_strings(): void {
        $this->assertEquals(
            3,
            f\count('foo')
        );
        $this->assertEquals(
            0,
            f\count('')
        );
        $this->assertEquals(
            4,
            f\count('ok 👍')
        );
    }

    public function test_should_count_stringable_objects(): void {
        $miles = new MockMusician('Miles', 'Davis');
        $this->assertEquals(
            11,
            f\count($miles)
        );
    }

    public function test_should_throw_exception_for_invalid_objects(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->assertEquals(
            0,
            f\count(new stdClass())
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\count));
    }
}
