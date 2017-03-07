<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class UniqueTest extends TestCase {

    public function test_should_work_with_simple_arrays() {
        $this->assertEquals(
            array('a', 'b', 'c'),
            f\unique(array('a', 'b', 'b', 'c', 'a'))
        );
        $this->assertEquals(
            array(true, 0, 1, false),
            f\unique(array(true, 0, 1, false, false, true, 1))
        );
    }

    public function test_should_work_with_multidimensional_arrays() {
        $musicians = array(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'),
        );

        $this->assertEquals(
            array(
                array(
                    'first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'
                ),
                array(
                    'first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'
                ),
                array(
                    'first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'
                ),
            ),
            f\unique($musicians)
        );
    }

    public function test_should_work_with_strings() {
        $this->assertEquals(
            array('a', 'r', 'd', 'v', 'k'),
            f\unique('aardvark')
        );
    }

}
