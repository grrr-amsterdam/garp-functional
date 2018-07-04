<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MergeAfterTest extends TestCase {

    public function test_should_merge_into_numerically_indexed_arrays() {
        $spices = array('nutmeg', 'clove', 'chile');
        $spices2 = f\merge_after('cinnamon', 2, $spices);
        $this->assertSame(
            array('nutmeg', 'clove', 'chile', 'cinnamon'),
            $spices2
        );
        $this->assertSame(
            array('nutmeg', 'clove', 'chile'),
            $spices,
            'It did not mutate the original'
        );

        $this->assertSame(
            array('nutmeg', 'cumin', 'clove', 'chile'),
            f\merge_after('cumin', 0, $spices),
            'It can add objects to the start of an array'
        );

        $this->assertSame(
            array('nutmeg', 'clove', 'chile', 'cinnamon'),
            f\merge_after('cinnamon', 999, $spices),
            'It will append objects to the end when index is larger than the length of the array'
        );

        $this->assertSame(
            array('nutmeg', 'clove', 'chile', array(1, 2, 3)),
            f\merge_after(array(1, 2, 3), 2, $spices),
            'It allows arrays to be merged'
        );

        $this->assertSame(
            array('nutmeg', 'clove', 'chile', array('foo' => 'cinnamon')),
            f\merge_after(array('foo' => 'cinnamon'), 'bar', $spices),
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
                'bar' => 456,
                'cux' => 999,
                'baz' => 789
            ),
            f\merge_after(array('cux' => 999), 'bar', $stuff)
        );
        $this->assertSame(
            array(
                'foo' => 123,
                'cux' => 999,
                'bar' => 456,
                'baz' => 789
            ),
            f\merge_after(array('cux' => 999), 'foo', $stuff)
        );

        $this->assertSame(
            array(
                'foo' => 123,
                0 => 999,
                'bar' => 456,
                'baz' => 789
            ),
            f\merge_after(999, 'foo', $stuff)
        );
        $this->assertSame(
            array(
                'foo' => 123,
                'bar' => 456,
                'baz' => 789,
                0 => 999,
            ),
            f\merge_after(999, 'baz', $stuff)
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
                'foo' => 123,
                'cux' => 999,
                'bar' => 456,
                'baz' => 789
            ),
            f\merge_after(array('cux' => 999), 0, $stuff)
        );
        $this->assertSame(
            array(
                'foo' => 123,
                'bar' => 456,
                'baz' => 789,
                'cux' => 999,
            ),
            f\merge_after(array('cux' => 999), 2, $stuff)
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
                'baz' => 789,
                0 => array(12, 24, 48),
            ),
            f\merge_after(array(12, 24, 48), 'baz', $stuff)
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
        $withThelonious = f\merge_after(
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
                'Herbie' => array(
                    'name' => 'Herbie Hancock',
                    'instrument' => 'piano'
                ),
                'Thelonious' => array(
                    'name' => 'Thelonious Monk',
                    'instrument' => 'piano'
                ),
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
            f\merge_after(
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
                array(7, 8, 9),
                array(4, 5, 6),
            ),
            f\merge_after(
                array(4, 5, 6),
                function ($val, $key) {
                    return $key === 1;
                },
                $arrays
            ),
            'It works with numeric arrays as well'
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
        $object = array('pop' => 'Michael');

        $this->assertSame(
            array(
                'jazz' => 'Miles',
                'soul' => 'Otis',
                'pop' => 'Michael',
                'rock' => 'Jimi'
            ),
            f\merge_after($object, 'soul', $target)
        );
    }

    public function test_should_be_curried() {
        $merger = f\merge_after('Miles', 1);
        $this->assertTrue(is_callable($merger));

        $this->assertSame(
            array('John', 'Herbie', 'Miles'),
            $merger(array('John', 'Herbie'))
        );
    }

}
