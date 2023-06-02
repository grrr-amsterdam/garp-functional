<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\CallableObject;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class EitherTest extends TestCase {

    public function test_should_return_first_thruty_value(): void {
        $this->assertEquals(
            'nutmeg',
            f\either('nutmeg', 'cinnamon')
        );
        $this->assertEquals(
            'nutmeg',
            f\either('', 'nutmeg')
        );
        $this->assertEquals(
            true,
            f\either(true, false)
        );
    }

    public function test_works_elegantly_with_prop(): void {
        $miles = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis'
        );
        $this->assertEquals(
            'Trumpet',
            f\either(f\prop('instrument', $miles), 'Trumpet')
        );
    }

    public function test_returns_new_function_when_given_at_least_one_function(): void {
        $users = array(
            array('name' => 'Hank', 'role' => 'admin'),
            array('name' => 'Julia', 'role' => 'basic'),
            array('name' => 'Lisa', 'role' => 'admin'),
            array('name' => 'Gerald')
        );
        $getBasicUsers = f\filter(
            f\either(
                f\not(f\prop('role')),
                f\prop_equals('role', 'basic')
            )
        );
        $this->assertEquals(
            array(
                array('name' => 'Julia', 'role' => 'basic'),
                array('name' => 'Gerald')
            ),
            $getBasicUsers($users)
        );
    }

    public function test_should_not_call_right_function_when_left_is_truthy(): void {
        $called = false;
        $changer = function () use (&$called) {
            $called = true;
        };
        $either = f\either(f\always(true), $changer);
        $either();
        $this->assertFalse($called);
    }

    public function test_should_work_with_callable_objects(): void {
        $obj = new CallableObject(24);

        $either = f\either($obj, null);
        $this->assertEquals(
            $obj, $either
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\either));
    }
}
