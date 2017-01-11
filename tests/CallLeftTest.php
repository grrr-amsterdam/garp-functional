<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class CallLeftTest extends TestCase {

    public function test_should_produce_partially_applied_function() {
        $this->assertTrue(
            is_callable(f\call_left('explode', '_'))
        );

        $sayHello = function ($to, $from, $message) {
            return "Hello {$to}, {$from} says '{$message}'";
        };
        $sayHelloToJohn = f\call_left($sayHello, 'John');
        $expected = 'Hello John, Hank says \'How\'s it going?\'';
        $this->assertEquals($expected, $sayHelloToJohn('Hank', 'How\'s it going?'));

        $hankGreetsJohn = f\call_left($sayHello, 'John', 'Hank');
        $expected = 'Hello John, Hank says \'How\'s it going?\'';
        $this->assertEquals($expected, $hankGreetsJohn('How\'s it going?'));

        $hankGreetsJohnComplete = f\call_left($sayHello, 'John', 'Hank', 'Hi there!');
        $expected = 'Hello John, Hank says \'Hi there!\'';
        $this->assertEquals($expected, $hankGreetsJohnComplete());

        $helloCopy = f\call_left($sayHello);
        $expected = 'Hello John, Hank says \'Hi there!\'';
        $this->assertEquals($expected, $helloCopy('John', 'Hank', 'Hi there!'));
    }

}
