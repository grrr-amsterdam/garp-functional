<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class WhenTest extends TestCase {

    public function test_should_be_simple_ternary_when_given_scalar_values() {
        $this->assertEquals(
            'cinnamon',
            f\when(true, 'cinnamon', 'nutmeg')
        );
    }

    public function test_should_accept_functions_for_more_interesting_results() {
        $this->assertEquals(
            'CINNAMON',
            f\when('is_string', 'strtoupper', 'f\id', 'cinnamon')
        );
    }

    public function test_should_work_splendidly_with_array_map() {
        $users = array(
            array('id' => 1, 'name' => 'Joe', 'type' => 'user'),
            array('id' => 2, 'name' => 'Hank', 'type' => 'admin'),
            array('id' => 3, 'name' => 'Alice', 'type' => 'user')
        );
        $mapped = array_map(
            f\when(
                f\prop_equals('type', 'admin'),
                f\concat_right(array('name' => 'Superadmin')),
                f\concat_right(array('name' => 'Regular Joe'))
            ),
            $users
        );
        $expected = array(
            array('id' => 1, 'name' => 'Regular Joe', 'type' => 'user'),
            array('id' => 2, 'name' => 'Superadmin', 'type' => 'admin'),
            array('id' => 3, 'name' => 'Regular Joe', 'type' => 'user')
        );
        $this->assertEquals($expected, $mapped);
    }

    public function test_should_work_with_callable_objects() {
        $obj1 = new CallableObject(12);
        $obj2 = new CallableObject(24);

        $this->assertEquals(
            $obj1,
            f\when(true, $obj1, $obj2)
        );
        $this->assertEquals(
            42,
            f\when($obj1, 42, 12)
        );
    }

}
