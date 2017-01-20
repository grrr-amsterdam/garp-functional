<?php
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
            array_values(f\filter('is_int', $data))
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
            array_values($filtered)
        );

        // Class method
        $this->assertEquals(
            array('clove'),
            array_values(f\filter(array($this, 'isSmallString'), $spices))
        );
    }

    public function test_should_be_curried() {
        $getAllStrings = f\filter('is_string');
        $data = array(123, 'abc', 456, true, array());
        $this->assertTrue(is_callable($getAllStrings));
        $this->assertEquals(
            array(1 => 'abc'),
            $getAllStrings($data)
        );
    }

    public function test_should_work_with_iterable_objects() {
        $traversable = new MockSpiceTraverser();
        $this->assertEquals(
            array(2 => 'clove'),
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

    public function isSmallString($str) {
        return strlen($str) <= 5;
    }

}
