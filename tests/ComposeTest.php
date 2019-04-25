<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ComposeTest extends TestCase {

    public function test_should_compose_functions() {
        $revAndUpper = f\compose('strrev', 'strtoupper');
        $this->assertEquals('GEMTUN', $revAndUpper('nutmeg'));

        $initials = f\compose(f\map(f\prop(0)), f\partial('explode', ' '));
        $this->assertEquals(
            ['M', 'D'],
            $initials('Miles Davis')
        );
    }

    public function test_should_allow_n_arguments() {
        $splitMapAndJoin = f\compose(f\join('_'), f\map('strrev'), f\split(' '));
        $miles = 'Miles Davis';
        $this->assertEquals(
            'seliM_sivaD',
            $splitMapAndJoin($miles)
        );

        $getInitials = f\compose(
            f\join(' '), f\map(f\compose(f\concat_right('.'), f\prop(0))), f\split(' ')
        );
        $this->assertEquals(
            'M. D.',
            $getInitials('Miles Davis')
        );
    }

    public function test_what_happens_without_arguments() {
        $emptyCompose = f\compose();
        $this->assertEquals(
            'whaddayaknow',
            $emptyCompose('whaddayaknow')
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\compose));
    }
}
