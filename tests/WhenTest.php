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
                f\join_right(array('name' => 'Superadmin')),
                f\join_right(array('name' => 'Regular Joe'))
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

}
