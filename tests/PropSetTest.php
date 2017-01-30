<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PropSetTest extends TestCase {

    public function test_should_set_property() {
        $musician = array('first_name' => 'Miles', 'last_name' => 'Davis');
        $this->assertEquals(
            array('first_name' => 'John', 'last_name' => 'Davis'),
            f\prop_set('first_name', 'John', $musician)
        );
    }

    public function test_should_make_a_copy() {
        $miles = array('first_name' => 'Miles', 'last_name' => 'Davis');
        $john = f\prop_set('first_name', 'John', $miles);
        $this->assertEquals(
            array('first_name' => 'John', 'last_name' => 'Davis'),
            $john
        );
        $this->assertEquals(
            array('first_name' => 'Miles', 'last_name' => 'Davis'),
            $miles
        );
    }

    public function test_should_be_thrice_curried() {
        $miles = array('first_name' => 'Miles', 'last_name' => 'Davis');
        $setFirstName = f\prop_set('first_name');
        $this->assertTrue(is_callable($setFirstName));
        $this->assertEquals(
            array('first_name' => 'John', 'last_name' => 'Davis'),
            $setFirstName('John', $miles)
        );
        $setFirstNameToJohn = $setFirstName('John');
        $this->assertTrue(is_callable($setFirstNameToJohn));
        $this->assertEquals(
            array('first_name' => 'John', 'last_name' => 'Davis'),
            $setFirstNameToJohn($miles)
        );
    }

}
