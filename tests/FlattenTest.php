<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class FlattenTest extends TestCase {

    public function test_should_flatten_arrays() {
        $test = array(
            1, 2, 3,
            array(4, 5, 6),
            array(7, 8, 9),
            array(10, 11, array(12, 13)),
            14, 15, array(16),
            array()
        );

        $fixture = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16);
        $this->assertEquals(
            $fixture,
            f\flatten($test)
        );
    }

    public function test_should_flatten_iterable_objects() {
        $test = array(
            new MockSpiceTraverser,
            1, 2, 3,
            new MockSpiceTraverser,
            4, 5, 6
        );

        $fixture = array(
            'nutmeg', 'cinnamon', 'clove', 1, 2, 3, 'nutmeg', 'cinnamon', 'clove', 4, 5, 6
        );
        $this->assertEquals(
            $fixture,
            f\flatten($test)
        );
    }

}
