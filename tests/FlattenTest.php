<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class FlattenTest extends TestCase {

    public function test_should_flatten_arrays() {
        $test = [
            1, 2, 3,
            [4, 5, 6],
            [7, 8, 9],
            [10, 11, [12, 13]],
            14, 15, [16],
            []
        ];

        $fixture = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
        $this->assertEquals(
            $fixture,
            f\flatten($test)
        );
    }

    public function test_should_flatten_iterable_objects() {
        $test = [
            new MockSpiceTraverser,
            1, 2, 3,
            new MockSpiceTraverser,
            4, 5, 6
        ];

        $fixture = [
            'nutmeg', 'cinnamon', 'clove', 1, 2, 3, 'nutmeg', 'cinnamon', 'clove', 4, 5, 6
        ];
        $this->assertEquals(
            $fixture,
            f\flatten($test)
        );
    }

    public function test_should_leave_associative_arrays_intact() {
        $test = [
            [['id' => 1, 'name' => 'Hank'], ['id' => 2, 'name' => 'Linda']],
            [['id' => 3, 'name' => 'Jones']]
        ];
        $fixture = [
            ['id' => 1, 'name' => 'Hank'],
            ['id' => 2, 'name' => 'Linda'],
            ['id' => 3, 'name' => 'Jones']
        ];

        $this->assertEquals(
            $fixture,
            f\flatten($test)
        );
    }
}
