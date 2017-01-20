<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class JoinRightTest extends TestCase {

    public function test_should_join_arrays() {
        $a = array(1, 2, 3);
        $b = array(4, 5, 6);
        $this->assertEquals(
            array(4, 5, 6, 1, 2, 3),
            f\join_right($a, $b)
        );
    }

    public function test_should_join_assoc_arrays() {
        $a = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis'
        );
        $b = array(
            'instrument' => 'trumpet'
        );
        $this->assertEquals(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            f\join_right($a, $b)
        );
    }

    public function test_should_join_strings() {
        $this->assertEquals(
            'DavisMiles',
            f\join_right('Miles', 'Davis')
        );
    }

    public function test_should_join_strings_to_arrays_if_either_argument_is_array() {
        $this->assertEquals(
            array('Davis', 'Miles'),
            f\join_right('Miles', array('Davis'))
        );
        $this->assertEquals(
            array('Davis', 'Miles'),
            f\join_right(array('Miles'), 'Davis')
        );
    }

    public function test_should_be_curried() {
        $joinMiles = f\join_right('Miles');
        $this->assertTrue(is_callable($joinMiles));

        $this->assertEquals('DavisMiles', $joinMiles('Davis'));
        $this->assertEquals(
            ' DavisMiles',
            $joinMiles(f\join(' ', 'Davis'))
        );

        $joinRightArray = f\join_right(array('name' => 'Joe'));
        $this->assertEquals(
            array('name' => 'Joe'),
            $joinRightArray(array('name' => 'Hank'))
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_should_throw_on_invalid_arguments() {
        f\join_right(1, 2);
    }

}
