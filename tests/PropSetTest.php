<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\CallableObject;
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

    public function test_should_accept_a_function_as_2nd_parameter_which_gets_applied_to_the_3rd() {
        $obj = array(
            'first_name' => 'John',
            'last_name' => 'Coltrane'
        );
        $setEmail = f\prop_set(
            'email',
            function ($o) {
                return strtolower(f\concat(f\prop('first_name', $o), '@gmail.com'));
            }
        );
        $this->assertEquals(
            array(
                'first_name' => 'John',
                'last_name' => 'Coltrane',
                'email' => 'john@gmail.com'
            ),
            $setEmail($obj)
        );

        $people = array(
            array('name' => 'Alice'),
            array('name' => 'Bob'),
        );
        $people = f\map(
            f\prop_set(
                'name',
                f\compose('strrev', f\prop('name'))
            ),
            $people
        );
        $this->assertEquals(
            array(
                array('name' => 'ecilA'),
                array('name' => 'boB')
            ),
            $people
        );

    }

    public function test_should_work_with_callable_objects() {
        $obj = new CallableObject(24);
        $this->assertEquals(
            array('object' => $obj),
            f\prop_set('object', $obj, array())
        );
    }

}
