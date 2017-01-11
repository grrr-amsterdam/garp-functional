<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PickTest extends TestCase {

    public function test_should_pick_from_array() {
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
        $spiceTraverser = new MockSpiceTraverser;
        $this->assertEquals(
            array(1 => 'cinnamon', 2 => 'clove'),
            f\pick(array(1, 2), $spiceTraverser)
        );
    }

}
