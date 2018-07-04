<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MergeAtTest extends TestCase {

    public function test_should_merge_into_numerically_indexed_arrays() {
        $spices = array('nutmeg', 'clove', 'chile');
        $spices2 = f\merge_at('cinnamon', 2, $spices);
        $this->assertSame(
            array('nutmeg', 'clove', 'cinnamon', 'chile'),
            $spices2
        );
        $this->assertSame(
            array('nutmeg', 'clove', 'chile'),
            $spices,
            'It did not mutate the original'
        );

        $this->assertSame(
            array('cumin', 'nutmeg', 'clove', 'chile'),
            f\merge_at('cumin', 0, $spices),
            'It can add objects to the start of an array'
        );

        $this->assertSame(
            array('nutmeg', 'clove', 'chile', 'cinnamon'),
            f\merge_at('cinnamon', 999, $spices),
            'It will append objects to the end when index is larger than the length of the array'
        );

        $this->assertSame(
            array('nutmeg', 'clove', array(1, 2, 3), 'chile'),
            f\merge_at(array(1, 2, 3), 2, $spices),
            'It allows arrays to be merged'
        );

        $this->assertSame(
            array('nutmeg', 'clove', 'chile', array('foo' => 'cinnamon')),
            f\merge_at(array('foo' => 'cinnamon'), 'bar', $spices),
            'It will ignore assoc-style identifiers for numeric arrays.'
        );
    }

    public function test_should_merge_associative_arrays() {
        $stuff = array(
            'foo' => 123,
            'bar' => 456,
            'baz' => 789
        );
        $this->assertSame(
            array(
                'foo' => 123,
                'cux' => 999,
                'bar' => 456,
                'baz' => 789
            ),
            f\merge_at(array('cux' => 999), 'bar', $stuff)
        );
        $this->assertSame(
            array(
                'cux' => 999,
                'foo' => 123,
                'bar' => 456,
                'baz' => 789
            ),
            f\merge_at(array('cux' => 999), 'foo', $stuff)
        );

        $this->assertSame(
            array(
                0 => 999,
                'foo' => 123,
                'bar' => 456,
                'baz' => 789
            ),
            f\merge_at(999, 'foo', $stuff)
        );
        $this->assertSame(
            array(
                'foo' => 123,
                'bar' => 456,
                0 => 999,
                'baz' => 789
            ),
            f\merge_at(999, 'baz', $stuff)
        );
    }

    public function test_should_merge_numeric_index_in_associative_array() {
        $stuff = array(
            'foo' => 123,
            'bar' => 456,
            'baz' => 789
        );
        $this->assertSame(
            array(
                'cux' => 999,
                'foo' => 123,
                'bar' => 456,
                'baz' => 789
            ),
            f\merge_at(array('cux' => 999), 0, $stuff)
        );
        $this->assertSame(
            array(
                'foo' => 123,
                'bar' => 456,
                'cux' => 999,
                'baz' => 789
            ),
            f\merge_at(array('cux' => 999), 2, $stuff)
        );
    }

    public function test_should_merge_regular_array_into_associative_array() {
        $stuff = array(
            'foo' => 123,
            'bar' => 456,
            'baz' => 789
        );
        $this->assertSame(
            array(
                'foo' => 123,
                'bar' => 456,
                0 => array(12, 24, 48),
                'baz' => 789
            ),
            f\merge_at(array(12, 24, 48), 'baz', $stuff)
        );
    }

    public function test_should_accept_predicate_function_as_index() {
        $jazz = array(
            'Miles' => array(
                'name' => 'Miles Davis',
                'instrument' => 'trumpet'
            ),
            'John' => array(
                'name' => 'John Coltrane',
                'instrument' => 'saxophone'
            ),
            'Herbie' => array(
                'name' => 'Herbie Hancock',
                'instrument' => 'piano'
            )
        );
        $withThelonious = f\merge_at(
            array('Thelonious' => array('name' => 'Thelonious Monk', 'instrument' => 'piano')),
            f\unary(f\prop_equals('instrument', 'piano')),
            $jazz
        );
        $this->assertSame(
            array(
                'Miles' => array(
                    'name' => 'Miles Davis',
                    'instrument' => 'trumpet'
                ),
                'John' => array(
                    'name' => 'John Coltrane',
                    'instrument' => 'saxophone'
                ),
                'Thelonious' => array(
                    'name' => 'Thelonious Monk',
                    'instrument' => 'piano'
                ),
                'Herbie' => array(
                    'name' => 'Herbie Hancock',
                    'instrument' => 'piano'
                )
            ),
            $withThelonious,
            'A callable argument will be used to determine target index'
        );

        $this->assertSame(
            array(
                'Miles' => array(
                    'name' => 'Miles Davis',
                    'instrument' => 'trumpet'
                ),
                'John' => array(
                    'name' => 'John Coltrane',
                    'instrument' => 'saxophone'
                ),
                'Herbie' => array(
                    'name' => 'Herbie Hancock',
                    'instrument' => 'piano'
                ),
                'Alice' => array(
                    'name' => 'Alice Coltrane',
                    'instrument' => 'harp'
                )
            ),
            f\merge_at(
                array('Alice' => array('name' => 'Alice Coltrane', 'instrument' => 'harp')),
                f\prop_equals('instrument', 'harp'),
                $jazz
            ),
            'When the function won\'t yield a match, the item is appended'
        );

        $arrays = array(
            array(1, 2, 3),
            array(7, 8, 9)
        );
        $this->assertSame(
            array(
                array(1, 2, 3),
                array(4, 5, 6),
                array(7, 8, 9)
            ),
            f\merge_at(
                array(4, 5, 6),
                function ($val, $key) {
                    return $key === 1;
                },
                $arrays
            ),
            'It works with numeric arrays as well'
        );
    }

    public function test_should_be_curried() {
        $merger = f\merge_at('Miles', 1);
        $this->assertTrue(is_callable($merger));

        $this->assertSame(
            array('John', 'Miles', 'Herbie'),
            $merger(array('John', 'Herbie'))
        );
    }

    /** @test */
    public function if_object_is_already_in_target_then_just_move_the_object_in_the_target() {
        $target = array(
            'jazz' => 'Miles',
            'pop' => 'Michael',
            'soul' => 'Otis',
            'rock' => 'Jimi'
        );
        $object = array('jazz' => 'Miles');

        $this->assertSame(
            array(
                'pop' => 'Michael',
                'jazz' => 'Miles',
                'soul' => 'Otis',
                'rock' => 'Jimi'
            ),
            f\merge_at($object, 'soul', $target)
        );
    }

}

