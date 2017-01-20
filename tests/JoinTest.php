<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class JoinTest extends TestCase {

    public function test_should_join_arrays() {
        $a = array(1, 2, 3);
        $b = array(4, 5, 6);
        $this->assertEquals(
            array(1, 2, 3, 4, 5, 6),
            f\join($a, $b)
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
            f\join($a, $b)
        );
    }

    public function test_should_join_strings() {
        $this->assertEquals(
            'MilesDavis',
            f\join('Miles', 'Davis')
        );
    }

    public function test_should_join_strings_to_arrays_if_either_argument_is_array() {
        $this->assertEquals(
            array('Miles', 'Davis'),
            f\join('Miles', array('Davis'))
        );
        $this->assertEquals(
            array('Miles', 'Davis'),
            f\join(array('Miles'), 'Davis')
        );
    }

    public function test_should_be_curried() {
        $joinMiles = f\join('Miles');
        $this->assertTrue(is_callable($joinMiles));

        $this->assertEquals('MilesDavis', $joinMiles('Davis'));
        $this->assertEquals(
            'Miles Davis',
            $joinMiles(f\join(' ', 'Davis'))
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_should_throw_on_invalid_arguments() {
        f\join(1, 2);
    }

}
