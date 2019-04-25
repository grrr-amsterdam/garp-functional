<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PipeTest extends TestCase {

    public function test_should_pipe_functions() {
        $revAndUpper = f\pipe('strtoupper', 'strrev');
        $this->assertEquals('GEMTUN', $revAndUpper('nutmeg'));

        $initials = f\pipe(f\partial('explode', ' '), f\map(f\prop(0)));
        $this->assertEquals(
            ['M', 'D'],
            $initials('Miles Davis')
        );
    }

    public function test_should_allow_n_arguments() {
        $splitMapAndJoin = f\pipe(f\split(' '), f\map('strrev'), f\join('_'));
        $miles = 'Miles Davis';
        $this->assertEquals(
            'seliM_sivaD',
            $splitMapAndJoin($miles)
        );

        $getInitials = f\pipe(
            f\split(' '), f\map(f\pipe(f\prop(0), f\concat_right('.'))), f\join(' ')
        );
        $this->assertEquals(
            'M. D.',
            $getInitials('Miles Davis')
        );
    }

    public function test_what_happens_without_arguments() {
        $emptyPipe = f\pipe();
        $this->assertEquals(
            'whaddayaknow',
            $emptyPipe('whaddayaknow')
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\pipe));
    }
}
