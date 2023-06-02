<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Types\StringM;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ConcatRightTest extends TestCase {

    public function test_should_concat_arrays(): void {
        $a = array(1, 2, 3);
        $b = array(4, 5, 6);
        $this->assertEquals(
            array(4, 5, 6, 1, 2, 3),
            f\concat_right($a, $b)
        );
    }

    public function test_should_concat_assoc_arrays(): void {
        $a = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis'
        );
        $b = array(
            'instrument' => 'trumpet'
        );
        $this->assertEquals(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            f\concat_right($a, $b)
        );
    }

    public function test_left_overrides_right(): void {
        $a = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis'
        );
        $b = array(
            'first_name' => 'John'
        );
        $this->assertEquals(
            array('first_name' => 'Miles', 'last_name' => 'Davis'),
            f\concat_right($a, $b)
        );
    }

    public function test_should_concat_strings(): void {
        $this->assertEquals(
            'DavisMiles',
            f\concat_right('Miles', 'Davis')
        );
    }

    public function test_should_concat_strings_to_arrays_if_either_argument_is_array(): void {
        $this->assertEquals(
            array('Davis', 'Miles'),
            f\concat_right('Miles', array('Davis'))
        );
        $this->assertEquals(
            array('Davis', 'Miles'),
            f\concat_right(array('Miles'), 'Davis')
        );
    }

    public function test_should_cast_numbers_to_strings(): void {
        $this->assertEquals(
            '95042',
            f\concat_right(
                42, 50, 9
            )
        );
        $this->assertEquals(
            '4.095',
            f\concat_right(5, 4.09)
        );
    }

    public function test_should_be_variadic(): void {
        $this->assertEquals(
            [7, 8, 9, 4, 5, 6, 1, 2, 3],
            f\concat_right(
                [1, 2, 3],
                [4, 5, 6],
                [7, 8, 9]
            )
        );
    }

    public function test_should_be_curried(): void {
        $concatMiles = f\concat_right('Miles');
        $this->assertTrue(is_callable($concatMiles));

        $this->assertEquals('DavisMiles', $concatMiles('Davis'));
        $this->assertEquals(
            ' DavisMiles',
            $concatMiles(f\concat(' ', 'Davis'))
        );

        $concatRightArray = f\concat_right(array('name' => 'Joe'));
        $this->assertEquals(
            array('name' => 'Joe'),
            $concatRightArray(array('name' => 'Hank'))
        );
    }

    public function test_should_throw_on_boolean_arguments(): void {
        $this->expectException(InvalidArgumentException::class);
        f\concat_right(true, false);
    }

    public function test_should_throw_on_invalid_object(): void {
        $this->expectException(InvalidArgumentException::class);
        f\concat_right('This', 'will', 'go', new stdClass(), 'wrong');
    }

    public function test_should_allow_semigroups(): void {
        $this->assertEquals(
            new StringM('foobar'),
            f\concat_right(new StringM('bar'), new StringM('foo'))
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\concat_right));
    }
}
