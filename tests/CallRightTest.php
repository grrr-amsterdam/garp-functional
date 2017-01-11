<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class CallRightTest extends TestCase {

    public function test_should_produce_partially_applied_function() {
        $this->assertTrue(
            is_callable(f\call_right('explode', 'foo_bar'))
        );

        $sayHello = function ($to, $from, $message) {
            return "Hello {$to}, {$from} says '{$message}'";
        };
        $askDirections = f\call_right($sayHello, "Where's the supermarket?");
        $expected = 'Hello John, Hank says \'Where\'s the supermarket?\'';
        $this->assertEquals($expected, $askDirections('John', 'Hank'));

        $lindaAsksDirections = f\call_right($sayHello, 'Linda', "Where's the drugstore?");
        $expected = 'Hello John, Linda says \'Where\'s the drugstore?\'';
        $this->assertEquals($expected, $lindaAsksDirections('John'));

        $lindaGreetsJohnComplete = f\call_right($sayHello, 'John', 'Linda', 'Hi there!');
        $expected = 'Hello John, Linda says \'Hi there!\'';
        $this->assertEquals($expected, $lindaGreetsJohnComplete());

        $helloCopy = f\call_right($sayHello);
        $expected = 'Hello John, Linda says \'Hi there!\'';
        $this->assertEquals($expected, $helloCopy('John', 'Linda', 'Hi there!'));
    }

}
