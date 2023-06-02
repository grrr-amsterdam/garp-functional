<?php
use Garp\Functional\Tests\Helpers\MockSpiceTraverser;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class RejectTest extends TestCase {

    public function test_should_reject_array(): void {
        $data = [123, 'abc', 456, true, []];

        // Native PHP function.
        $this->assertEquals(
            ['abc', true, []],
            f\reject('is_int', $data)
        );

        // Closure
        $spices = ['nutmeg', 'cinnamon', 'clove'];
        $filtered = f\reject(
            function ($spice) {
                return strlen($spice) > 6;
            },
            $spices
        );

        $this->assertEquals(
            ['nutmeg', 'clove'],
            $filtered
        );

        // Class method
        $this->assertEquals(
            ['nutmeg', 'cinnamon'],
            f\reject([$this, 'isSmallString'], $spices)
        );
    }

    public function test_should_be_curried(): void {
        $rejectAllStrings = f\reject('is_string');
        $data = [123, 'abc', 456, true, []];
        $this->assertTrue(is_callable($rejectAllStrings));
        $this->assertEquals(
            [123, 456, true, []],
            $rejectAllStrings($data)
        );
    }

    public function test_should_work_with_iterable_objects(): void {
        $traversable = new MockSpiceTraverser();
        $this->assertEquals(
            [0 => 'nutmeg', 1 => 'cinnamon'],
            f\reject([$this, 'isSmallString'], $traversable)
        );
    }

    public function test_should_keep_string_indexes(): void {
        $muppets = [
            'Kermit' => ['type' => 'frog', 'color' => 'green'],
            'Miss Piggy' => ['type' => 'pig', 'color' => 'pink'],
        ];
        $greenMuppets = f\reject(
            f\prop_equals('color', 'green'),
            $muppets
        );
        $this->assertEquals(
            ['Miss Piggy'],
            array_keys($greenMuppets)
        );
    }

    public function test_should_reindex_numeric_indexes(): void {
        $numbers = [1000, 30.50, 490, 555];
        $bigNumbers = f\reject(f\gt(500), $numbers);
        $this->assertEquals(
            [30.50, 490],
            $bigNumbers
        );
    }

    public function isSmallString(string $str): bool {
        return strlen($str) <= 5;
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\reject));
    }
}
