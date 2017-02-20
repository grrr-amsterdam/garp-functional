<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class OmitTest extends TestCase {

    public function test_should_omit_from_assoc_array() {
        $data = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis',
            'instrument' => 'trumpet',
            'country' => 'USA'
        );
        $fixture = array(
            'last_name' => 'Davis',
            'country' => 'USA'
        );

        $this->assertEquals(
            $fixture,
            f\omit(array('first_name', 'instrument'), $data)
        );
    }

    public function test_should_pick_from_numeric_array() {
        $spices = array('nutmeg', 'clove', 'cinnamon');
        $this->assertEquals(
            array(1 => 'clove', 2 => 'cinnamon'),
            f\omit(array(0), $spices)
        );
        $this->assertEquals(
            $spices,
            f\omit(array(), $spices)
        );
    }

    public function test_should_be_curried() {
        $getFullName = f\omit(array('instrument', 'country'));
        $data = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis',
            'instrument' => 'trumpet',
            'country' => 'USA'
        );
        $this->assertTrue(is_callable($getFullName));
        $this->assertEquals(
            array('first_name' => 'Miles', 'last_name' => 'Davis'),
            $getFullName($data)
        );
    }

    public function test_should_work_with_iterable_objects() {
        $musician = new stdClass;
        $musician->first_name = 'Miles';
        $musician->last_name = 'Davis';
        $musician->instrument = 'trumpet';
        $musician->country = 'USA';
        $this->assertEquals(
            array('first_name' => 'Miles', 'instrument' => 'trumpet'),
            f\omit(array('country', 'last_name'), $musician)
        );
    }

}
