<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class IfElseTest extends TestCase {

    public function test_should_if_else_curried() {
        $thenSubject = [
            'color' => 'green'
        ];

        $elseSubject = [
            'color' => 'red'
        ];

        $test = f\if_else(
            f\prop_equals('color', 'green'),
            f\always('then'),
            f\always('else')
        );

        $this->assertEquals(
            $test($thenSubject),
            'then'
        );

        $this->assertEquals(
            $test($elseSubject),
            'else'
        );
    }

    public function test_should_if_else() {
        $thenSubject = [
            'color' => 'green'
        ];

        $elseSubject = [
            'color' => 'red'
        ];

        $testThen = f\if_else(
            f\prop_equals('color', 'green'),
            f\always('then'),
            f\always('else'),
            $thenSubject
        );

        $testElse = f\if_else(
            f\prop_equals('color', 'green'),
            f\always('then'),
            f\always('else'),
            $elseSubject
        );

        $this->assertEquals(
            $testThen,
            'then'
        );

        $this->assertEquals(
            $testElse,
            'else'
        );
    }

    public function test_if_else_example() {
        $doubleOrTriple = f\if_else(
            f\gt(10),
            f\multiply(2),
            f\multiply(3)
        );

        $this->assertEquals(
            $doubleOrTriple(20),
            40
        );

        $this->assertEquals(
            $doubleOrTriple(5),
            15
        );
    }

}
