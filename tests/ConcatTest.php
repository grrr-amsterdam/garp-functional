<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockMusician;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ConcatTest extends TestCase {

    public function test_should_concat_arrays() {
        $a = array(1, 2, 3);
        $b = array(4, 5, 6);
        $this->assertEquals(
            array(1, 2, 3, 4, 5, 6),
            f\concat($a, $b)
        );
    }

    public function test_should_concat_assoc_arrays() {
        $a = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis'
        );
        $b = array(
            'instrument' => 'trumpet'
        );
        $this->assertEquals(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            f\concat($a, $b)
        );
    }

    public function test_right_overrides_left() {
        $a = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis'
        );
        $b = array(
            'first_name' => 'John'
        );
        $this->assertEquals(
            array('first_name' => 'John', 'last_name' => 'Davis'),
            f\concat($a, $b)
        );
    }

    public function test_should_concat_strings() {
        $this->assertEquals(
            'MilesDavis',
            f\concat('Miles', 'Davis')
        );
        $this->assertEquals(
            '🔥💦',
            f\concat('🔥', '💦')
        );
    }

    public function test_should_concat_strings_to_arrays_if_either_argument_is_array() {
        $this->assertEquals(
            array('Miles', 'Davis'),
            f\concat('Miles', array('Davis'))
        );
        $this->assertEquals(
            array('Miles', 'Davis'),
            f\concat(array('Miles'), 'Davis')
        );
    }

    public function test_should_work_with_stringable_objects() {
        $miles = new MockMusician('Miles', 'Davis');
        $john = new MockMusician('John', 'Coltrane');
        $this->assertEquals(
            'Miles DavisJohn Coltrane',
            f\concat($miles, $john)
        );
    }

    public function test_should_cast_numbers_to_strings() {
        $this->assertEquals(
            '42509',
            f\concat(
                42, 50, 9
            )
        );
        $this->assertEquals(
            '54.09',
            f\concat(5, 4.09)
        );
    }

    public function test_should_be_variadic() {
        $this->assertEquals(
            range(1, 9),
            f\concat(
                [1, 2, 3],
                [4, 5, 6],
                [7, 8, 9]
            )
        );
    }

    public function test_should_be_curried() {
        $concatMiles = f\concat('Miles');
        $this->assertTrue(is_callable($concatMiles));

        $this->assertEquals('MilesDavis', $concatMiles('Davis'));
        $this->assertEquals(
            'Miles Davis',
            $concatMiles(f\concat(' ', 'Davis'))
        );
    }

    public function test_should_be_curried_down_to_no_arguments() {
        $concatAnything = f\concat();
        $this->assertTrue(is_callable($concatAnything));
        $this->assertEquals(
            'foobar',
            $concatAnything('foo', 'bar')
        );
    }

    public function test_should_concat_null() {
        $actual = f\concat(['test'], null);

        $this->assertEquals(['test', null], $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_should_throw_on_boolean_arguments() {
        f\concat(1, true);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_should_throw_on_invalid_object() {
        f\concat('This', 'will', 'go', new stdClass(), 'wrong');
    }

}
