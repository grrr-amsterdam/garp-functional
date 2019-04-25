<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class FilterTest extends TestCase {

    public function test_should_filter_array() {
        $data = array(123, 'abc', 456, true, array());

        // Native PHP function.
        $this->assertEquals(
            array(123, 456),
            f\filter('is_int', $data)
        );

        // Closure
        $spices = array('nutmeg', 'cinnamon', 'clove');
        $filtered = f\filter(
            function ($spice) {
                return strlen($spice) > 6;
            },
            $spices
        );

        $this->assertEquals(
            array('cinnamon'),
            $filtered
        );

        // Class method
        $this->assertEquals(
            array('clove'),
            f\filter(array($this, 'isSmallString'), $spices)
        );
    }

    public function test_should_be_curried() {
        $getAllStrings = f\filter('is_string');
        $data = array(123, 'abc', 456, true, array());
        $this->assertTrue(is_callable($getAllStrings));
        $this->assertEquals(
            array('abc'),
            $getAllStrings($data)
        );
    }

    public function test_should_work_with_iterable_objects() {
        $traversable = new MockSpiceTraverser();
        $this->assertEquals(
            array(0 => 'clove'),
            f\filter(array($this, 'isSmallString'), $traversable)
        );
    }

    public function test_should_keep_string_indexes() {
        $muppets = array(
            'Kermit' => array('type' => 'frog', 'color' => 'green'),
            'Miss Piggy' => array('type' => 'pig', 'color' => 'pink'),
        );
        $greenMuppets = f\filter(
            function ($muppet) {
                return $muppet['color'] === 'green';
            },
            $muppets
        );
        $this->assertEquals(
            array('Kermit'),
            array_keys($greenMuppets)
        );
    }

    public function test_should_reindex_numeric_indexes() {
        $numbers = array(1000, 30.50, 490, 555);
        $bigNumbers = f\filter(f\gt(500), $numbers);
        $this->assertEquals(
            array(1000, 555),
            $bigNumbers
        );
    }

    public function isSmallString($str) {
        return strlen($str) <= 5;
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\filter));
    }
}
