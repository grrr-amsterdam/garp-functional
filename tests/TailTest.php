<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TailTest extends TestCase {

    public function test_should_grab_tail_of_arrays() {
        $spices = array('nutmeg', 'clove', 'cinnamon');
        $this->assertEquals(
            array('clove', 'cinnamon'),
            f\tail($spices)
        );
    }

    public function test_should_grab_tail_of_strings() {
        $miles = 'Miles';
        $this->assertEquals(
            'iles',
            f\tail($miles)
        );
    }

    public function test_should_grab_tail_from_traversable() {
        $spiceIterator = new MockSpiceTraverser();
        $this->assertEquals(
            array('cinnamon', 'clove'),
            f\tail($spiceIterator)
        );
    }

    public function test_should_get_empty_array_from_empty_collection() {
        $this->assertEquals(
            array(),
            f\tail(array())
        );
    }

    public function test_should_get_empty_string_from_empty_string() {
        $this->assertEquals(
            '',
            f\tail('')
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_should_throw_exception_on_unusable_input() {
        f\tail(12345);
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\tail));
    }
}
