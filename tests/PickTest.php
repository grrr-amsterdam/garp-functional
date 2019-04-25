<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PickTest extends TestCase {

    public function test_should_pick_from_assoc_array() {
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
            f\pick(array('last_name', 'country'), $data)
        );
    }

    public function test_should_pick_from_numeric_array() {
        $spices = array('nutmeg', 'clove', 'cinnamon');
        $this->assertEquals(
            array(1 => 'clove', 2 => 'cinnamon'),
            f\pick(array(1, 2), $spices)
        );
    }

    public function test_should_be_curried() {
        $getFullName = f\pick(array('first_name', 'last_name'));
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
            f\pick(array('first_name', 'instrument'), $musician)
        );
    }

    public function test_superfluous_keys_should_not_be_added_to_the_object() {
        $data = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis',
            'instrument' => 'trumpet',
            'country' => 'USA'
        );
        $picked = f\pick(array('first_name', 'last_name', 'date_of_birth', 'gender'), $data);
        $this->assertEquals(
            array('first_name' => 'Miles', 'last_name' => 'Davis'),
            $picked
        );
    }
    public function test_named_constant() {
        $this->assertTrue(is_callable(f\pick));
    }
}
