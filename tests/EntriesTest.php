<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class EntriesTest extends TestCase {

    public function test_should_work_with_numeric_indexed_array() {
        $this->assertEquals(
            [[0, 'foo'], [1, 'bar'], [2, 'baz']],
            f\entries(['foo', 'bar', 'baz'])
        );
        $this->assertEquals(
            [[0, 'Miles'], [1, 'John'], [2, 'Herbie']],
            f\entries(['Miles', 'John', 'Herbie'])
        );
        $this->assertEquals(
            [],
            f\entries([])
        );
    }

    public function test_should_work_with_assoc_arrays() {
        $this->assertEquals(
            [['foo', 123], ['bar', 456]],
            f\entries(['foo' => 123, 'bar' => 456])
        );
        $this->assertEquals(
            [['first_name', 'Jane'], ['last_name', 'Doe']],
            f\entries(['first_name' => 'Jane', 'last_name' => 'Doe'])
        );
    }

    public function test_should_work_with_iterable_objects() {
        $fruits = [
            'apple',
            'orange',
            'grape',
            'plum'
        ];
        $obj = new ArrayObject($fruits);
        $itr = $obj->getIterator();
        $this->assertEquals(
            [[0, 'apple'], [1, 'orange'], [2, 'grape'], [3, 'plum']],
            f\entries($itr)
        );
    }

}
